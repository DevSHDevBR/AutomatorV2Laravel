<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_paginations_cols', function (Blueprint $table) {
          
        $table->id('tbl_sys_paginations_col_ID');

        $table->foreignId('tbl_sys_pagination_ID')
              ->constrained('tbl_sys_paginations', 'tbl_sys_pagination_ID')
              ->cascadeOnDelete();

        $table->foreignId('tbl_sys_field_type_ID')
              ->constrained('tbl_sys_field_types', 'tbl_sys_field_type_ID')
              ->cascadeOnDelete();

        $table->string('tbl_sys_paginations_col_name', 255);
        $table->string('tbl_sys_paginations_col_title', 255);
        $table->text('tbl_sys_paginations_col_header')->nullable();
        $table->text('tbl_sys_paginations_col_body')->nullable();
        $table->text('tbl_sys_paginations_col_props')->nullable();
        $table->text('tbl_sys_paginations_col_attrs')->nullable();
        $table->boolean('tbl_sys_paginations_col_search')->default(false);
        $table->boolean('tbl_sys_paginations_col_sort')->default(false);
        $table->integer('tbl_sys_paginations_col_ordem');
        $table->timestamp('tbl_sys_paginations_col_created')->useCurrent();
        $table->timestamp('tbl_sys_paginations_col_updated')->nullable()->useCurrentOnUpdate();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_paginations_cols');
    

    }


  
  };