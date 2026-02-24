<?php

namespace App\Enums;

enum UserRole :string 
{
    case ADMIN = 'admin';
    case ORGANIZER = 'organizer';
    case CLUBBER = 'clubber';
}

/*
en el modelo:
protected function casts(): array
{
    return [
        'role' => \App\Enums\UserRole::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

*/
?>