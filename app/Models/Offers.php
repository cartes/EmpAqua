<?php

namespace App\Models;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Offers
 *
 * @property int $id
 * @property int $id_business
 * @property string $title
 * @property string $description
 * @property int $handicapped
 * @property string $area
 * @property string $sub_area
 * @property string $address
 * @property string $city
 * @property string $comune
 * @property string $state
 * @property int|null $salary
 * @property string $position
 * @property string|null $benefits
 * @property string|null $requirements
 * @property int $period
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Business $Business
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidates[] $Candidates
 * @property-read int|null $candidates_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereBenefits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereHandicapped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereIdBusiness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereSubArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Business $business
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidates[] $candidates
 * @property string|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereStatus($value)
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereCountry($value)
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $User
 * @property-read int|null $user_count
 * @property-read \App\Models\BusinessMeta $businessMeta
 * @property-read mixed $date
 * @property-read mixed $publication
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Offers onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereComune($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Offers withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Offers withoutTrashed()
 * @property string|null $experience
 * @property string|null $views
 * @property string|null $expirated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Benefit[] $Benefits
 * @property-read int|null $benefits_count
 * @property-read mixed $expiration_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereExpiratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereViews($value)
 * @property int|null $featured
 * @property-read mixed $is_new
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offers whereFeatured($value)
 */
class Offers extends Model
{
    use SoftDeletes, DatesTranslator;

    const REVIEWED = 1;
    const INTERVIEW = 2;

    /**
     * @var string
     */
    protected $table = "aquabe_offers";
    protected $withCount = ['candidates'];
    protected $fillable = [
        'id_business',
        'title',
        'slug',
        'description',
        'handicapped',
        'area',
        'sub_area',
        'address',
        'country',
        'city',
        'state',
        'commune',
        'salary',
        'salary_array',
        'category_id',
        'position',
        'experience',
        'visit',
        'requirements',
        'period',
        'status',
        'featured',
        'published',
        'vacancy',
        'expirated_at'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'id_business', 'id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidates::class, 'id_offer', 'id');
    }

    public function User()
    {
        return $this->belongsToMany(User::class, 'aquabe_offers_candidates', 'id_offer', 'id_user')
            ->withPivot('status');
    }

    public function Benefits()
    {
        return $this->hasMany(Benefit::class, 'offer_id', 'id');
    }

    public function businessMeta()
    {
        return $this->belongsTo(BusinessMeta::class, 'id_business', 'id_business');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function getFeaturedEndDateAttribute() {
        $publication = $this->attributes['created_at'];
        
        return Carbon::parse($publication)->addDays(3);
    }

    public function getPublicationAttribute()
    {
        $publication = $this->attributes['created_at'];

        return Carbon::parse($publication)->diffForHumans();
    }

    public function getIsNewAttribute()
    {
        $publication = $this->attributes['created_at'];
        if (Carbon::parse($publication)->diffInHours() < 20) {
            return true;
        } else {
            return false;
        }
    }

    public function getSalaryAttribute()
    {
        $minSalary = $this->attributes['salary'];
        $opt = $this->attributes['salary_array'];
        
        if ($minSalary <= 10000 || $opt == '0') {
            return 'A convenir';
        }
        
        if ($opt == '2') {
            $range = explode(' - ', $minSalary);
            if (count($range) >= 2)
            {
                $min = $range[0];
                $max = $range[1];
            } else {
                $min = $range[0];
                $max = $range[0];

            }
            $salary = new \NumberFormatter("es_CL", \NumberFormatter::DECIMAL);
            $salaryMin = $salary->format($min);
            $salaryMax = $salary->format($max);
            return $salaryMin . ' - ' . $salaryMax;
        }

        $salary = new \NumberFormatter("es_CL", \NumberFormatter::DECIMAL);
        return $salary->format($this->attributes['salary']);
    }

    public function getSumaAttribute()
    {
        $candidates = $this->withCount('candidates');

        return $candidates;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

    public function getExpirationDateAttribute()
    {
        $starts = Carbon::parse($this->attributes['expirated_at']);
        return $starts->format('d/m/Y');
    }

    public function getStatusAttribute()
    {
        $expiration = Carbon::parse($this->attributes['expirated_at']);

        if ($expiration < Carbon::now()) {
            return '<i class="fas fa-minus-circle text-danger" data-toggle="popover" data-content="Oferta expirada" data-trigger="hover"></i>';
        } elseif ($expiration <= Carbon::now()->addDays(2)) {
            return '<i class="fas fa-minus-circle text-danger" data-toggle="popover" data-content="Oferta a punto de expirar" data-trigger="hover"></i>';
        } elseif ($expiration <= Carbon::now()->addDays(7)) {
            return '<i class="fas fa-exclamation-circle text-warning" data-toggle="popover" data-content="Oferta expira en menos de 7 días" data-trigger="hover"></i>';
        } else {
            return '<i class="fas fa-check-circle text-success"></i>';
        }
    }
    
    public function getConfidentialAttribute()
    {
        $confidential = $this->attributes['status'];
        
        if ($confidential == 1 || is_null($confidential)) {
            return true;
        } else {
            return false;
        }
    }

    public function getViewsAttribute()
    {
        $id = session()->get('id');
        $offers = Offers::whereIdBusiness($id)->select('visit')->get();
        $sum = 0;

        foreach ($offers as $view) {
            $sum += (int) $view->view;
        }

        return $sum;
    }

    public function getPositionAttribute()
    {
        $position = $this->attributes['position'];
        
        switch ($position) {

            case 0: $txt = 'A definir'; break;
            case 1: $txt = 'Full-time'; break;
            case 2: $txt = 'Part-time'; break;
            case 3: $txt = 'Turnos'; break;
        }

        return $txt;
    }
    
    
    public function getExperienceAttribute()
    {
        $experience = $this->attributes['experience'];
        
        $txt = 'Prestación Servicios';

        switch ($experience) {
            case '0': $txt = 'Prestación Servicios'; break;
            case '1': $txt = 'Indefinido'; break;
            case '2': $txt = 'Plazo Fijo'; break;
            case '3': $txt = 'Honorarios'; break;
        }

        return $txt;
    }
}
