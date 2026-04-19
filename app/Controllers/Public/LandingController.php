<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;
use App\Libraries\PackageCatalog;

class LandingController extends BaseController
{
    public function index()
    {
        return implode('', [
            view('web/header', ['pageTitle' => 'Surancy - Insurance Agency HTML Template']),
            view('web/index', ['packages' => PackageCatalog::all()]),
            view('web/footer'),
        ]);
    }
}
