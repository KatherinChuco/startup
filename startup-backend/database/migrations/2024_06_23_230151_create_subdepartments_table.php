<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubdepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdepartments', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_department_id');
            $table->unsignedBigInteger('subdepartment_id');
            $table->primary(['parent_department_id', 'subdepartment_id']);
            $table->foreign('parent_department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('subdepartment_id')->references('id')->on('departments')->onDelete('cascade');
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
        Schema::dropIfExists('subdepartments');
    }
}