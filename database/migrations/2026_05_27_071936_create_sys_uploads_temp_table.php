<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_uploads_temp', function (Blueprint $table) {
      
        $table->id('tbl_sys_upload_temp_ID');

        $table->unsignedBigInteger('tbl_sys_uploads_type_ID')->nullable();

        $table->string('tbl_sys_upload_temp_file', 255);

        $table->text('tbl_sys_upload_temp_directory')->nullable();

        $table->unsignedBigInteger('tbl_user_ID')->nullable();

        $table->timestamp('tbl_sys_upload_temp_created_at')->useCurrent();
        $table->timestamp('tbl_sys_upload_temp_updated_at')->nullable()->useCurrentOnUpdate();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_uploads_temp');


    }



  };