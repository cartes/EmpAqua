<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Paginator::useBootstrapFour();

        try {
            if (\Illuminate\Support\Facades\DB::connection()->getDriverName() === 'sqlite') {
                $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
                $pdo->sqliteCreateFunction('STR_TO_DATE', function ($str, $format = null) {
                    if (!$str) {
                        return null;
                    }
                    $parts = explode('-', (string) $str);
                    if (count($parts) === 3 && strlen($parts[2]) === 4) {
                        return sprintf('%04d-%02d-%02d', (int) $parts[2], (int) $parts[1], (int) $parts[0]);
                    }
                    return $str;
                }, 2);
            }
        } catch (\Throwable $e) {
            // Ignore if DB connection is not ready
        }

        Validator::extend('cl_rut', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value) && !is_numeric($value)) {
                return false;
            }
            $rut = preg_replace('/[^kK0-9]/', '', (string) $value);
            if (strlen($rut) < 2) {
                return false;
            }
            $dv = strtoupper(substr($rut, -1));
            $numero = substr($rut, 0, -1);
            if (!ctype_digit($numero)) {
                return false;
            }
            $i = 2;
            $suma = 0;
            foreach (array_reverse(str_split($numero)) as $v) {
                if ($i == 8) {
                    $i = 2;
                }
                $suma += ((int) $v) * $i;
                $i++;
            }
            $dvr = 11 - ($suma % 11);
            if ($dvr == 11) {
                $dvr = '0';
            } elseif ($dvr == 10) {
                $dvr = 'K';
            } else {
                $dvr = (string) $dvr;
            }
            return $dv === $dvr;
        });
    }
}
