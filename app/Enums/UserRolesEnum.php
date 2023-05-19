<?php



namespace App\Enums;

enum UserRolesEnum: string
{
    case Admin = 'admin';

    case SuperAdmin = 'superadmin';

    case User = 'user';

    case Customer = 'customer';
}
