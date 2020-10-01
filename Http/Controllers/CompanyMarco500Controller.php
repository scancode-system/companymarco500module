<?php

namespace Modules\CompanyMarco500\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Subsidiary\Entities\Subsidiary;
use Modules\CompanyMarco500\Exports\ProductsExport;
use Modules\CompanyMarco500\Exports\OrdersExport;
use Modules\CompanyMarco500\Http\Requests\OrderRequest;
use Maatwebsite\Excel\Facades\Excel;

class CompanyMarco500Controller extends Controller
{

    public function index(Request $request)
    {
        return view('companymarco500::index');
    }

    public function orders(OrderRequest $request)
    {
        if($request->action != 'excel'){
            return view('companymarco500::orders.orders', ['start' => $request->start, 'end' => $request->end, 'start_end_date' => $request->start_end_date]);
        } else {
            return Excel::download(new OrdersExport($request->start, $request->end), 'Relatório de Vendas das Filials.xlsx');
        }
    }

    public function ordersExport(Request $request, $date = null)
    {
        return Excel::download(new OrdersExport($date), 'Relatório de Vendas das Filials.xlsx');
    }

    public function products(Request $request)
    {
        return view('companymarco500::products.products');
    }

    public function productsExport(Request $request, Subsidiary $subsidiary, $date = null)
    {
        return Excel::download(new ProductsExport($subsidiary, $date), 'Relatório de Produtos por Filial(s).xlsx');
    }

}
