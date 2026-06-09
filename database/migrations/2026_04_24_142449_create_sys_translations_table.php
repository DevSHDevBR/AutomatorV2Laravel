<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_translations', function (Blueprint $table) {


        $table->id('tbl_sys_translation_ID');
        $table->string('tbl_sys_translation_key', 20)->unique();
        $table->string('tbl_sys_translation_name', 255);
        $table->text('tbl_sys_translation_description')->nullable();
        $table->boolean('tbl_sys_translation_locked')->default(false);
        $table->timestamp('tbl_sys_translation_created_at')->useCurrent();
        $table->timestamp('tbl_sys_translation_updated_at')->nullable()->useCurrentOnUpdate();
      

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_translations');
    

    }



  };
