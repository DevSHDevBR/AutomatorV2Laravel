<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {
    


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_uploads_types', function (Blueprint $table) {
        
        $table->id('tbl_sys_uploads_type_ID');
        $table->string('tbl_sys_uploads_type_icon', 255)->nullable()->default('picture');
        $table->string('tbl_sys_uploads_type_mine', 255);
        $table->string('tbl_sys_uploads_type_name', 255)->unique();
        $table->string('tbl_sys_uploads_type_title', 255);
        $table->text('tbl_sys_uploads_type_description')->nullable();
        $table->boolean('tbl_sys_uploads_type_locked')->default(false);
        $table->timestamp('tbl_sys_uploads_type_created_at')->useCurrent();
        $table->timestamp('tbl_sys_uploads_type_updated_at')->nullable()->useCurrentOnUpdate();
      
      });
    

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_uploads_types');
    

    }
  


  };
