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
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ControllersSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function business(int $role = 90): Business
    {
        $business = Business::create([
            'rut_user' => '11111111-1',
            'firstname' => 'Ana',
            'surname' => 'Perez',
            'email_user' => 'ana@example.com',
            'position' => 'RRHH',
            'phone_user' => '123',
            'password' => Hash::make('secret1'),
        ]);
        BusinessMeta::create(['id_business' => $business->id, 'business_name' => 'ACME']);
        Role::create(['id_business' => $business->id, 'role' => (string) $role]);

        return $business;
    }

    public function test_business_can_pause_close_and_republish_without_losing_candidates(): void
    {
        $business = $this->business(Membership::Basic->value);
        $offer = Offers::create([
            'id_business' => $business->id, 'title' => 'Oferta de prueba', 'slug' => 'estado-oferta',
            'description' => 'd', 'area' => 'a', 'sub_area' => '', 'position' => '1',
            'experience' => '1', 'published' => 1, 'expirated_at' => now()->addDays(15),
        ]);
        $user = User::create(['rut_user' => '22222222-2', 'name' => 'Luis', 'surname' => 'Soto', 'email' => 'luis@example.com', 'password' => Hash::make('x')]);
        $candidate = $offer->candidates()->create(['id_user' => $user->id, 'status' => 2]);
        $url = route('offer.publication-status', $offer->slug);
        $session = ['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value];

        $this->withSession($session)->get(route('offer.admin'))->assertOk()->assertSee($url, false)->assertSee('Inactiva');
        $this->patch($url, ['publication_status' => 'invalid'])->assertSessionHasErrors('publication_status');
        $this->patch($url, ['publication_status' => 'inactive'])->assertRedirect();
        $this->assertEquals(Offers::INACTIVE, $offer->fresh()->published);
        $this->assertCount(1, $this->get(route('offer.admin'))->viewData('offers'));

        $this->withSession(['id' => $user->id, 'role' => 'user'])->get(route('offer.postulate', $offer->slug))->assertSessionHas('message.0', 'warning');
        $this->assertEquals(2, $candidate->fresh()->getRawOriginal('status'));
        $this->get(route('offer.show', $offer->slug))->assertNotFound();
        $this->get(route('offer.list'))->assertDontSee('Oferta de prueba');
        $this->patch($url, ['publication_status' => 'active'])->assertRedirect();
        $this->assertEquals(Offers::INACTIVE, $offer->fresh()->published);

        $this->withSession(['id' => $business->id + 100, 'role' => 'business'])->patch($url, ['publication_status' => 'closed'])->assertForbidden();
        $this->withSession($session)->patch($url, ['publication_status' => 'active'])->assertRedirect();
        $this->assertEquals(Offers::ACTIVE, $offer->fresh()->published);
        $expiration = $offer->fresh()->expirated_at;
        $this->patch($url, ['publication_status' => 'closed'])->assertRedirect();
        $this->assertEquals(Offers::CLOSED, $offer->fresh()->published);
        $this->assertEquals($expiration, $offer->fresh()->expirated_at);
        $panel = $this->get(route('offer.admin'))->assertOk()->assertSee('Cerrada');
        $this->assertCount(0, $panel->viewData('offers'));
        $this->assertCount(1, $panel->viewData('expired'));
        $this->get(route('offer.candidates', $offer->slug))->assertOk()->assertSee('Luis');
        $this->patch($url, ['publication_status' => 'active'])->assertSessionHas('message.0', 'warning');
        $this->assertEquals(Offers::CLOSED, $offer->fresh()->published);
        $this->withSession(['id' => $user->id, 'role' => 'user'])->get(route('offer.postulate', $offer->slug))->assertSessionHas('message.0', 'warning');
        $this->get(route('offer.show', $offer->slug))->assertNotFound();
        $this->withSession($session)->put(route('offer.republish', $offer->slug))->assertRedirect();
        $this->assertEquals(Offers::ACTIVE, $offer->fresh()->published);
        $this->assertEquals(2, $candidate->fresh()->getRawOriginal('status'));
        $this->assertSame(1, $offer->fresh()->candidates()->count());
    }

    public function test_public_pages_render(): void
    {
        $business = $this->business();
        Offers::create([
            'id_business' => $business->id,
            'title' => 'Aviso',
            'slug' => 'aviso-1',
            'description' => 'd',
            'area' => 'a',
            'sub_area' => '',
            'position' => '1',
            'experience' => '1',
            'published' => 1,
            'expirated_at' => now()->addDays(5),
        ]);

        foreach (['/', '/contacto', '/newsletter', '/offer/list', '/offer/featured', '/offer/show/aviso-1', '/about', '/prices', '/faq', '/terms'] as $path) {
            $html = $this->get($path)->assertOk()->getContent();
            $this->assertSame(1, preg_match_all('/<h1\b/i', $html), "Expected exactly one <h1> on {$path}");
        }
    }

    public function test_business_login_sets_membership_session(): void
    {
        $this->business(Membership::Basic->value);

        $this->post('/business/login', ['email' => 'ana@example.com', 'password' => 'secret1'])
            ->assertRedirect(route('offer.admin'));

        $this->assertSame('business', session('role'));
        $this->assertSame('10', session('role_id'));
    }

    public function test_business_edit_route_accessible_by_business_and_admin(): void
    {
        // Admin role (0)
        $business = $this->business(Membership::Admin->value);
        $this->post('/business/login', ['email' => 'ana@example.com', 'password' => 'secret1']);
        $this->get('/business/edit')->assertOk();

        // Standard business role (10)
        $this->flushSession();
        $this->business(Membership::Basic->value);
        $this->post('/business/login', ['email' => 'ana@example.com', 'password' => 'secret1']);
        $this->get('/business/edit')->assertOk();

        // Legacy session without explicit role
        $this->withSession(['id' => $business->id])
            ->get('/business/edit')
            ->assertOk();

        // Candidate user is blocked
        $user = User::create(['rut_user' => '22222222-2', 'name' => 'Luis', 'surname' => 'Soto', 'email' => 'luis@example.com', 'password' => Hash::make('x')]);
        $this->withSession(['id' => $user->id, 'role' => 'user'])
            ->get('/business/edit')
            ->assertRedirect(route('/'));

        // Unauthenticated guest is redirected to login
        $this->flushSession();
        $this->get('/business/edit')
            ->assertRedirect(route('business.login'));
    }

    public function test_business_creates_and_lists_offers(): void
    {
        $business = $this->business(Membership::Basic->value);
        $this->post('/business/login', ['email' => 'ana@example.com', 'password' => 'secret1']);

        $this->post('/offer/create', [
            'title' => 'Operador de planta',
            'category_id' => 1,
            'position' => '1',
            'salary_opt' => '0',
            'comune' => 'Puerto Montt',
            'handicapped' => '0',
            'description' => 'Descripcion de la oferta',
            'area' => 'Produccion',
            'experience' => '2',
            'requirements' => 'Requisitos',
            'vacancy' => '1',
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
            'business_name' => 'X',
            'business_position' => 'Y',
            'experience_level' => '1',
            'year_from' => '2020',
            'description' => 'd',
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
            'name' => 'Ana',
            'email' => 'ana@example.com',
            'phone' => '123',
            'subject' => 'Hola',
            'message_user' => 'Mensaje',
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
            'email' => 'ana@example.com',
            'token' => $token,
            'password' => 'nueva-clave',
            'password_confirmation' => 'nueva-clave',
        ])->assertSessionHas('message.0', 'success');

        $this->assertTrue(Hash::check('nueva-clave', Business::first()->password));
        $this->assertDatabaseCount('password_resets', 0);
    }

    public function test_mailer_sends_html_through_laravel_mail(): void
    {
        config(['mail.default' => 'array']);

        $this->assertTrue(app(Mailer::class)->send('a@example.com', 'Asunto', '<p>Hola</p>'));

        $sent = app('mail.manager')->mailer('array')->getSymfonyTransport()->messages();
        $this->assertCount(1, $sent);
        $this->assertStringContainsString('Asunto', $sent[0]->getOriginalMessage()->getSubject());
    }

    public function test_postulations_are_counted_in_business_admin_panel(): void
    {
        Storage::fake('public');
        $pdf = '%PDF-1.4 test CV';
        Storage::disk('public')->put('resume/cv-luis.pdf', $pdf);

        $business = $this->business(Membership::Basic->value);
        $offer = Offers::create([
            'id_business' => $business->id,
            'title' => 'Jefe de Centro',
            'slug' => 'jefe-de-centro-1',
            'description' => 'd',
            'area' => 'a',
            'sub_area' => '',
            'position' => '1',
            'experience' => '1',
            'published' => 1,
            'expirated_at' => now()->addDays(15),
        ]);

        $user1 = User::create(['rut_user' => '22222222-2', 'name' => 'Luis', 'surname' => 'Soto', 'email' => 'luis@example.com', 'password' => Hash::make('x')]);
        $user1->userMeta()->create(['path' => 'cv-luis.pdf', 'filename' => 'cv-luis.pdf']);
        $user2 = User::create(['rut_user' => '33333333-3', 'name' => 'Eva', 'surname' => 'Rios', 'email' => 'eva@example.com', 'password' => Hash::make('x')]);

        $this->withSession(['id' => $user1->id, 'role' => 'user'])
            ->get(route('offer.postulate', $offer->slug))
            ->assertRedirect();

        $this->withSession(['id' => $user2->id, 'role' => 'user'])
            ->get(route('offer.postulate', $offer->slug))
            ->assertRedirect();

        $response = $this->withSession(['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value])
            ->get(route('offer.admin'))
            ->assertOk();

        $response->assertSee(route('offer.candidates', $offer->slug), false);
        $this->assertSame(2, $response->viewData('offers')->first()->candidates_count);

        $candidatesPage = $this->withSession(['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value])
            ->get(route('offer.candidates', $offer->slug))
            ->assertOk();

        $this->assertCount(2, $candidatesPage->viewData('candidates'));
        $candidatesPage->assertSee(route('user.resume', [$user1->id, $offer->id]), false);

        $cvUrl = route('user.resume', [$user1->id, $offer->id]);
        $cv = $this->get($cvUrl)->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('inline;', $cv->headers->get('content-disposition'));
        $this->assertSame($pdf, $cv->streamedContent());

        // También se admiten rutas que ya incluyen el directorio resume.
        $user1->userMeta->update(['path' => 'resume/cv-luis.pdf']);
        $this->assertSame($pdf, $this->get($cvUrl)->assertOk()->streamedContent());
        $user1->userMeta->update(['path' => 'cv-luis.pdf']);

        $this->get(route('user.resume', [$user2->id, $offer->id]))->assertNotFound();
        $this->withSession(['id' => $business->id + 100, 'role' => 'business'])->get($cvUrl)->assertForbidden();
        $this->withSession(['id' => $user2->id, 'role' => 'user'])->get($cvUrl)->assertForbidden();

        // Ficha curricular del candidato accesible tanto por empresa como por administrador
        $this->withSession(['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value])
            ->get(route('user.file', [$user1->id, $offer->id]))
            ->assertOk()
            ->assertSee('Perfil de Luis Soto')
            ->assertSee(route('user.resume', [$user1->id, $offer->id]), false);

        $this->withSession(['id' => $business->id, 'role' => 'administrador', 'role_id' => (string) Membership::Admin->value])
            ->get(route('user.file', [$user1->id, $offer->id]))
            ->assertOk()
            ->assertSee('Perfil de Luis Soto')
            ->assertSee(route('user.resume', [$user1->id, $offer->id]), false);

        $this->get($cvUrl)->assertOk();

        // Cuando la oferta se cierra/vence, las postulaciones y sus CVs siguen visibles en ofertas cerradas
        $offer->update(['expirated_at' => now()->subDay()]);

        $expiredAdmin = $this->withSession(['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value])
            ->get(route('offer.admin'))
            ->assertOk();

        $this->assertSame(2, $expiredAdmin->viewData('expired')->first()->candidates_count);
        $expiredAdmin->assertSee(route('offer.candidates', $offer->slug), false);

        $expiredCandidatesPage = $this->withSession(['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value])
            ->get(route('offer.candidates', $offer->slug))
            ->assertOk();

        $this->get($cvUrl)->assertOk();
        Storage::disk('public')->delete('resume/cv-luis.pdf');
        $this->get($cvUrl)->assertNotFound();

        $this->assertCount(2, $expiredCandidatesPage->viewData('candidates'));
        $expiredCandidatesPage->assertSee(route('user.resume', [$user1->id, $offer->id]), false);

        $profilePage = $this->withSession(['id' => $business->id, 'role' => 'business', 'role_id' => (string) Membership::Basic->value])
            ->get(route('business.profile'))
            ->assertOk();

        $this->assertSame(2, $profilePage->viewData('candidates'));
    }
}
