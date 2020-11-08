<?php

namespace Modules\CompanyMarco500\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CompanyMarco500\Http\Requests\SallerClientRequest;
use Modules\CompanyMarco500\Http\Requests\ClientRequest;
use Modules\CompanyMarco500\Exports\SallerTotalsExport;
use Modules\CompanyMarco500\Exports\SallerClientExport;
use Modules\CompanyMarco500\Exports\ClientExport;

class XlsxController extends Controller
{

    public function sallerTotals(){
        return Excel::download(new SallerTotalsExport(), 'Representantes - Totais.xlsx');
    }

    public function sallerClient(SallerClientRequest $request){
        return Excel::download(new SallerClientExport($request->saller_id, $request->date), 'Representantes - Cliente.xlsx');
    }

    public function client(ClientRequest $request){
        return Excel::download(new ClientExport($request->date), 'Cliente.xlsx');
    }

}
