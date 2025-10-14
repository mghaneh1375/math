<?php

namespace App\Enums;

enum AccountStatus:string {

    case ACTIVE = 'ACTIVE';

    case PENDING = 'PENDING';

    case BLOCK = 'BLOCK';

}