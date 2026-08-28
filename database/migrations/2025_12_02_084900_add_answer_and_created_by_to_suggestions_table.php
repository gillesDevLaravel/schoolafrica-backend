<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswerAndCreatedByToSuggestionsTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('suggestions', function (Blueprint $table) {
            if (!Schema::hasColumn('suggestions', 'answer')) {
                $table->text('answer')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suggestions', function (Blueprint $table) {
            if (Schema::hasColumn('suggestions', 'answer')) {
                $table->dropColumn('answer');
            }
            if (Schema::hasColumn('suggestions', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
    }
};
