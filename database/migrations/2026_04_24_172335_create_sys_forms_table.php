<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_forms', function (Blueprint $table) {

        $table->id('tbl_sys_form_ID');
        $table->string('tbl_sys_form_name', 255)->unique();
        $table->string('tbl_sys_form_title', 255);
        $table->string('tbl_sys_form_cancel', 30)->default('Cancelar');
        $table->string('tbl_sys_form_submit', 30)->nullable();
        $table->string('tbl_sys_form_method', 30)->nullable();
        $table->string('tbl_sys_form_route', 255)->nullable();
        $table->boolean('tbl_sys_form_modal')->default(false);
        $table->boolean('tbl_sys_form_admin')->default(false);
        $table->boolean('tbl_sys_form_validate')->default(false);
        $table->boolean('tbl_sys_form_locked')->default(false);
        $table->timestamp('tbl_sys_form_created_at')->useCurrent();
        $table->timestamp('tbl_sys_form_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_forms');


    }
  


  };