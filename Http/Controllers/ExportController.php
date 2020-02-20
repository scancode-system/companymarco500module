<?php

namespace Modules\CompanyMarco500\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CompanyMarco500\Services\TxtService;

class ExportController extends Controller
{

    public function txtOrders(Request $request)
    {
        $txt =  new TxtService();
        $txt->run();
        return $txt->download();
    }

}
