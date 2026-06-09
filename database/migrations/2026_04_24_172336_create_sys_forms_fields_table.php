<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_forms_fields', function (Blueprint $table) {

        $table->id('tbl_sys_forms_field_ID');
        
        $table->foreignId('tbl_sys_form_ID')
              ->constrained('tbl_sys_forms', 'tbl_sys_form_ID')
              ->cascadeOnDelete();

        $table->foreignId('tbl_sys_field_type_ID')
              ->constrained('tbl_sys_field_types', 'tbl_sys_field_type_ID')
              ->cascadeOnDelete();

        $table->string('tbl_sys_forms_field_title', 255);
        $table->string('tbl_sys_forms_field_name', 255);
        $table->string('tbl_sys_forms_field_index', 255)->nullable();
        $table->text('tbl_sys_forms_field_class')->nullable();
        $table->text('tbl_sys_forms_field_default')->nullable();
        $table->text('tbl_sys_forms_field_props')->nullable();
        $table->text('tbl_sys_forms_field_attrs')->nullable();
        $table->boolean('tbl_sys_forms_field_required')->default(false);
        $table->boolean('tbl_sys_forms_field_locked')->default(false);
        $table->integer('tbl_sys_forms_field_ordem');
        $table->timestamp('tbl_sys_forms_field_created_at')->useCurrent();
        $table->timestamp('tbl_sys_forms_field_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_forms_fields');
    

    }



  };