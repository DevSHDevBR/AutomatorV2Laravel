<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_paginations_args', function (Blueprint $table) {
          
        $table->id('tbl_sys_paginations_arg_ID');

        $table->foreignId('tbl_sys_pagination_ID')
              ->constrained('tbl_sys_paginations', 'tbl_sys_pagination_ID')
              ->cascadeOnDelete();

        $table->string('tbl_sys_paginations_arg_name', 255);
        $table->text('tbl_sys_paginations_arg_value')->nullable();
        $table->timestamp('tbl_sys_paginations_arg_created')->useCurrent();
        $table->timestamp('tbl_sys_paginations_arg_updated')->nullable()->useCurrentOnUpdate();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_paginations_args');
    

    }


  
  };