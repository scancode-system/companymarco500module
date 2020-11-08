<?php

namespace Modules\CompanyMarco500\Http\ViewComposers\Xlsx;

use Modules\Dashboard\Services\ViewComposer\ServiceComposer;
use Modules\Saller\Entities\Saller;


class SallerClientComposer extends ServiceComposer 
{

    private $sallers;

    public function assign($view)
    {
        $this->sallers();
    }

    private function sallers()
    {
        $this->sallers = Saller::all()->pluck('name', 'id');
    }

    public function view($view){
        $view->with('sallers', $this->sallers);
    }

}