<?php

use App\Enums\Service\ServiceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_service_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('price');
            $table->enum('status', ServiceStatus::asArray())->default(ServiceStatus::Active);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('type_service_id')->references('id')->on('type_services')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
