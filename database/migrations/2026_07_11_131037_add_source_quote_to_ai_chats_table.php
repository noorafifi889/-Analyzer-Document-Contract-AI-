<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('ai_chats', function (Blueprint $table) {
        $table->text('source_quote')->nullable()->after('response');
    });
}

public function down(): void
{
    Schema::table('ai_chats', function (Blueprint $table) {
        $table->dropColumn('source_quote');
    });
    }
};
