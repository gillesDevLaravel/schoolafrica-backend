<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesToMoratoriumsTable extends Migration
{
    public function up()
    {
        Schema::table('moratoriums', function (Blueprint $table) {
            $table->text('note_comptable')->nullable()->after('reason');
            $table->text('note_fondatrice')->nullable()->after('note_comptable');
        });
    }

    public function down()
    {
        Schema::table('moratoriums', function (Blueprint $table) {
            $table->dropColumn(['note_comptable', 'note_fondatrice']);
        });
    }
}
