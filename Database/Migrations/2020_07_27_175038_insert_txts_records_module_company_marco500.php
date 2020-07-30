<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Modules\Dashboard\Repositories\TxtRepository;

class InsertTxtsRecordsModuleCompanyMarco500 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        TxtRepository::new(['module' => 'CompanyMarco500', 'service' => 'PedidosMarco500', 'alias' => 'Pedidos - Marco500']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        TxtRepository::deleteByAlias('Pedidos - Marco500');
    }
}
