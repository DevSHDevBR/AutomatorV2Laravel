<?php

  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_field_types', function (Blueprint $table) {

        $table->id('tbl_sys_field_type_ID');

        $table->foreignId('tbl_sys_field_type_group_ID')
              ->constrained('tbl_sys_field_types_groups', 'tbl_sys_field_type_group_ID')
              ->cascadeOnDelete();

        $table->string('tbl_sys_field_type_name', 255)->unique();
        $table->string('tbl_sys_field_type_class', 255)->nullable();
        $table->string('tbl_sys_field_type_icon', 255)->nullable()->default('id-card');
        $table->string('tbl_sys_field_type_title', 255);
        $table->text('tbl_sys_field_type_description')->nullable();
        $table->text('tbl_sys_field_type_params')->nullable();
        $table->text('tbl_sys_field_type_pagination')->nullable();
        $table->boolean('tbl_sys_field_type_layout')->default(false);
        $table->text('tbl_sys_field_type_configs')->nullable();
        $table->boolean('tbl_sys_field_type_locked')->default(false);
        $table->timestamp('tbl_sys_field_type_created_at')->useCurrent();
        $table->timestamp('tbl_sys_field_type_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_field_types');
    

    }
  


  };