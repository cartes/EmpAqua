<?php

namespace App\Enums;

/**
 * Planes de membresía de las empresas (columna `aquabe_roles.role`).
 *
 * El valor 16 está asignado a "Gold" y, históricamente, también a "Corporativo A5";
 * se conserva el primero porque es el que siempre aplicaron las reglas de negocio.
 */
enum Membership: int
{
    case Admin = 0;
    case Basic = 10;
    case Premium = 11;
    case CorporateA1 = 12;
    case CorporateA2 = 13;
    case CorporateA3 = 14;
    case CorporateA4 = 15;
    case Gold = 16;
    case CorporatePlus = 17;
    case Free = 90;

    /** Planes que puede asignar el administrador, en el orden del selector. */
    public static function assignable(): array
    {
        return [
            self::Free, self::Basic, self::Premium, self::Gold, self::CorporateA1,
            self::CorporateA2, self::CorporateA3, self::CorporateA4, self::CorporatePlus,
        ];
    }

    public static function fromSession(mixed $value): ?self
    {
        return ($value === null || $value === '') ? null : self::tryFrom((int) $value);
    }

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrador',
            self::Free => 'Gratis',
            self::Basic => 'Básico',
            self::Premium => 'Premium',
            self::Gold => 'Gold',
            self::CorporateA1 => 'Corporativo A1',
            self::CorporateA2 => 'Corporativo A2',
            self::CorporateA3 => 'Corporativo A3',
            self::CorporateA4 => 'Corporativo A4',
            self::CorporatePlus => 'Corporativo Plus',
        };
    }

    /** Cantidad de avisos destacados permitidos. */
    public function featuredAds(): int
    {
        return match ($this) {
            self::Basic => 3,
            self::Premium => 6,
            self::Gold => 9,
            self::CorporateA1 => 10,
            self::CorporateA2 => 12,
            self::CorporateA3 => 15,
            self::CorporateA4 => 30,
            self::CorporatePlus => 45,
            default => 0,
        };
    }

    /** Candidatos visibles por oferta (-1 = sin límite). */
    public function candidateLimit(): int
    {
        return match ($this) {
            self::Free => 1,
            self::Basic => 20,
            self::Premium => 35,
            self::Gold => 50,
            self::CorporateA1, self::CorporateA2, self::CorporateA3,
            self::CorporateA4, self::CorporatePlus => -1,
            default => 3,
        };
    }

    /** Días de vigencia del plan contados desde `updated_at`; null si no vence. */
    public function durationDays(): ?int
    {
        return match ($this) {
            self::Basic, self::Premium => 31,
            self::CorporateA1 => 90,
            self::CorporateA2 => 180,
            self::CorporateA3 => 270,
            self::CorporateA4, self::Gold, self::CorporatePlus => 365,
            default => null,
        };
    }

    /** Rol de sesión asociado al plan. */
    public function sessionRole(): string
    {
        return $this === self::Admin ? 'administrador' : 'business';
    }
}
