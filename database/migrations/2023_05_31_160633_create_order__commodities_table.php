<?php

use App\Models\Order;
use App\Models\Commodity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Order_Commodities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Commodity::class)->constrained();
            $table->foreignIdFor(Order::class)->constrained();
            $table->double('price');
            $table->integer('count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Order_Commodity\ies');
    }
};
