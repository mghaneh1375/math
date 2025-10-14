<?php

namespace App\Enums;

enum TransactionStatus:string {

    case INIT = 'INIT';

    case SUCCESS = 'SUCCESS';

    case FAIL = 'FAIL';

}