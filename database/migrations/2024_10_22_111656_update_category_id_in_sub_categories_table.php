<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryIdInSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            // $table->dropColumn('category_id');

            $table->foreignId('category_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('categories')
                  ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            // Drop the foreignId column in case of rollback
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // Re-add the old integer column
            $table->integer('category_id');
        });
    }
}

