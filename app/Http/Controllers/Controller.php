<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

include_once __DIR__ . '/Common.php';

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
