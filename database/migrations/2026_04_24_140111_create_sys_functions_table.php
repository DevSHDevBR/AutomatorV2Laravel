<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_sys_functions', function (Blueprint $table) {

        $table->id('tbl_sys_function_ID');
        $table->enum('tbl_sys_function_type', ['native', 'custom'])->default('native');
        $table->string('tbl_sys_function_name', 255)->unique();
        $table->text('tbl_sys_function_fn');
        $table->text('tbl_sys_function_params')->nullable();
        $table->timestamp('tbl_sys_function_created_at')->useCurrent();
        $table->timestamp('tbl_sys_function_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_functions');
    

    }



  };
