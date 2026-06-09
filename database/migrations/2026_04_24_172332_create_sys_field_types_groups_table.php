<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_field_types_groups', function (Blueprint $table) {

        $table->id('tbl_sys_field_type_group_ID');
        $table->string('tbl_sys_field_type_group_name', 255)->unique();
        $table->string('tbl_sys_field_type_group_title', 255);
        $table->boolean('tbl_sys_field_type_group_locked')->default(false);
        $table->integer('tbl_sys_field_type_group_ordem');
        $table->timestamp('tbl_sys_field_type_group_created')->useCurrent();
        $table->timestamp('tbl_sys_field_type_group_updated')->nullable()->useCurrentOnUpdate();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_field_types_groups');
    

    }



  };
