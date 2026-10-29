<?php

namespace Tests\Feature;

use App\Enums\Membership;
use App\Models\Business;
use App\Models\BusinessMeta;
use App\Models\Offers;
use App\Models\Role;
use App\Models\User;
use App\Services\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ControllersSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function business(int $role = 90): Business
    {
        $business = Business::create([
            'rut_user' => '11111111-1', 'firstname' => 'Ana', 'surname' => 'Perez',
            'email_user' => 'ana@example.com', 'position' => 'RRHH', 'phone_user' => '123',
            'password' => Hash::make('secret1'),
        ]);
        BusinessMeta::create(['id_business' => $business->id, 'business_name' => 'ACME']);
        Role::create(['id_business' => $business->id, 'role' => (string) $role]);

        return $business;
    }

    public function test_public_pages_render(): void
    {
        $business = $this->business();
        Offers::create([
            'id_business' => $business->id, 'title' => 'Aviso', 'slug' => 'aviso-1', 'description' => 'd', 'area' => 'a',
            'sub_area' => '', 'position' => '1', 'experience' => '1', 'published' => 1, 'expirated_at' => now()->addDays(5),
        ]);

        $this->get('/')->assertOk();
        $this->get('/contacto')->assertOk();
        $this->get('/newsletter')->assertOk();
        $this->get('/offer/list')->assertOk();
        $this->get('/offer/featured')->assertOk();
    }

    public function test_business_login_sets_membership_session(): void
    {
        $this->business(Membership::Basic->value);

        $this->post('/business/login', ['email' => 'ana@example.com', 'password' => 'secret1'])
            ->assertRedirect(route('offer.admin'));

        $this->assertSame('business', session('role'));
        $this->assertSame('10', session('role_id'));
    }

    public function test_business_creates_and_lists_offers(): void
    {
        $business = $this->business(Membership::Basic->value);
        $this->post('/business/login', ['email' => 'ana@example.com', 'password' => 'secret1']);

        $this->post('/offer/create', [
            'title' => 'Operador de planta', 'category_id' => 1, 'position' => '1', 'salary_opt' => '0',
            'comune' => 'Puerto Montt', 'handicapped' => '0', 'description' => 'Descripcion de la oferta',
            'area' => 'Produccion', 'experience' => '2', 'requirements' => 'Requisitos', 'vacancy' => '1',
            'benefits' => ['Seguro', 'Bono'],
        ])->assertRedirect();

        $offer = Offers::firstOrFail();
        $this->assertSame($business->id, $offer->id_business);
        $this->assertSame('Puerto Montt', $offer->comune);
        $this->assertCount(2, $offer->Benefits);

        $this->get('/offer/index')->assertOk();
        $this->get("/offer/show/{$offer->slug}")->assertOk();
        $this->get("/offer/{$offer->slug}/candidates")->assertOk();
    }

    public function test_user_cannot_manage_candidates_of_an_offer(): void
    {
        $this->business();
        $user = User::create(['rut_user' => '22222222-2', 'name' => 'Luis', 'surname' => 'Soto', 'email' => 'luis@example.com', 'password' => Hash::make('x')]);
        $offer = Offers::create(['id_business' => 1, 'title' => 't', 'slug' => 't-1', 'description' => 'd', 'area' => 'a', 'sub_area' => '', 'expirated_at' => now()->addDay()]);

        $this->withSession(['id' => $user->id, 'role' => 'user'])
            ->get("/offer/{$offer->slug}/candidates")
            ->assertForbidden();
    }

    public function test_candidate_profile_is_scoped_to_session_user(): void
    {
        $user = User::create(['rut_user' => '22222222-2', 'name' => 'Luis', 'surname' => 'Soto', 'email' => 'luis@example.com', 'password' => Hash::make('x')]);
        $other = User::create(['rut_user' => '33333333-3', 'name' => 'Eva', 'surname' => 'Rios', 'email' => 'eva@example.com', 'password' => Hash::make('x')]);
        $experience = $other->userExperience()->create([
            'business_name' => 'X', 'business_position' => 'Y', 'experience_level' => '1', 'year_from' => '2020', 'description' => 'd',
        ]);

        $this->withSession(['id' => $user->id, 'role' => 'user']);

        $this->get('/profile')->assertOk();
        $this->get("/profile/experience/{$experience->id_experience}")->assertNotFound();
        $this->put('/profile/profile/skills', ['skill' => 'PHP'])->assertRedirect();
        $this->assertSame('PHP', $user->userSkills()->first()->skill);
    }

    public function test_contact_is_stored_even_if_mail_fails(): void
    {
        $this->mock(Mailer::class)->shouldReceive('send')->once()->andReturn(false);

        $this->post('/contacto', [
            'name' => 'Ana', 'email' => 'ana@example.com', 'phone' => '123',
            'subject' => 'Hola', 'message_user' => 'Mensaje',
        ])->assertRedirect();

        $this->assertDatabaseHas('contacts', ['email' => 'ana@example.com', 'message' => 'Mensaje']);
    }

    public function test_password_reset_changes_business_password(): void
    {
        $this->business();
        $this->mock(Mailer::class)->shouldReceive('send')->once()->andReturn(true);

        $this->post('/resetBusinessPassword', ['email' => 'ana@example.com'])->assertSessionHas('message.0', 'success');

        $token = DB::table('password_resets')->value('token');

        $this->post('/sendNewBusinessPassword', [
            'email' => 'ana@example.com', 'token' => $token,
            'password' => 'nueva-clave', 'password_confirmation' => 'nueva-clave',
        ])->assertSessionHas('message.0', 'success');

        $this->assertTrue(Hash::check('nueva-clave', Business::first()->password));
        $this->assertDatabaseCount('password_resets', 0);
    }
}
