<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_forms_fields_access', function (Blueprint $table) {
        
        $table->id('tbl_sys_forms_fields_access_ID');

        $table->foreignId('tbl_users_type_ID')
              ->constrained('tbl_users_types', 'tbl_users_type_ID')
              ->cascadeOnDelete();

        $table->foreignId('tbl_sys_forms_field_ID')
              ->constrained('tbl_sys_forms_fields', 'tbl_sys_forms_field_ID')
              ->cascadeOnDelete();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_forms_fields_access');
    

    }
  


  };
