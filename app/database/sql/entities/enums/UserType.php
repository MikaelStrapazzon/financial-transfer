<?php

namespace App\database\sql\entities\enums;

enum UserType: string
{
    case INDIVIDUAL = 'individual';
    case STORE = 'store';
}
