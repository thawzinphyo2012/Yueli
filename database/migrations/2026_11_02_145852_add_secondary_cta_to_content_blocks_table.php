<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->string('cta2_label')->nullable()->after('cta_url');
            $table->string('cta2_url')->nullable()->after('cta2_label');
            $table->string('eyebrow')->nullable()->after('subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('content_blocks', function (Blueprint $table) {
            $table->dropColumn(['cta2_label', 'cta2_url', 'eyebrow']);
        });
    }
};
