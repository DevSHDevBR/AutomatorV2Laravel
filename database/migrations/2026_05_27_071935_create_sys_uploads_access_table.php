<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_uploads_access', function (Blueprint $table) {
      
        $table->id('tbl_sys_uploads_access_ID');

        $table->foreignId('tbl_user_ID')
                ->constrained('tbl_users', 'tbl_user_ID')
                ->cascadeOnDelete();

        $table->foreignId('tbl_sys_upload_ID')
                ->constrained('tbl_sys_uploads', 'tbl_sys_upload_ID')
                ->cascadeOnDelete();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_uploads_access');


    }



  };