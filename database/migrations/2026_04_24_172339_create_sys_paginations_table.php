<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_paginations', function (Blueprint $table) {

        $table->id('tbl_sys_pagination_ID');
        $table->string('tbl_sys_pagination_name', 255)->unique();
        $table->string('tbl_sys_pagination_route', 255);
        $table->string('tbl_sys_pagination_title', 255);
        $table->string('tbl_sys_pagination_table', 255);
        $table->string('tbl_sys_pagination_index', 255)->nullable();
        $table->boolean('tbl_sys_pagination_locked')->default(false);
        $table->timestamp('tbl_sys_pagination_created_at')->useCurrent();
        $table->timestamp('tbl_sys_pagination_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_paginations');


    }
  


  };