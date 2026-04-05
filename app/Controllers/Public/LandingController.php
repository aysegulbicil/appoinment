<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;

class LandingController extends BaseController
{
    public function index()
    {
        return implode('', [
            view('web/header', ['pageTitle' => 'Surancy - Insurance Agency HTML Template']),
            view('web/index'),
            view('web/footer'),
        ]);
    }
}
