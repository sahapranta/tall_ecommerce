<?php



namespace App\Enums;

enum ProductStatusEnum: string
{
    case Draft      = 'draft';
    case Published  = 'published';
    case Review     = 'review';
    case Archived   = 'archived';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
