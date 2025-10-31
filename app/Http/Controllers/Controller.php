<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends RoutingController
{
    use AuthorizesRequests;
}
