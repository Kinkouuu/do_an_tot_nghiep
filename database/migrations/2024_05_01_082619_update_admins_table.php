<?php

use App\Enums\User\UserGender;
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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('home_town')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('citizen_id')->nullable();
            $table->enum('gender', [UserGender::asArray()])->default(UserGender::Male);
            $table->timestamp('birth_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function($table) {
            $table->dropColumn('home_town');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('citizen_id');
            $table->dropColumn('gender');
            $table->dropColumn('birth_day');
        });
    }
};
