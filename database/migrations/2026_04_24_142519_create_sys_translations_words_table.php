<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_translations_words', function (Blueprint $table) {
        
        $table->id('tbl_translations_word_ID');
        $table->foreignId('tbl_sys_translation_ID')
          ->constrained('tbl_sys_translations', 'tbl_sys_translation_ID')
          ->cascadeOnDelete();
        $table->text('tbl_translations_word_name');
        $table->text('tbl_translations_word_str');
        $table->timestamp('tbl_translations_word_created_at')->useCurrent();
        $table->timestamp('tbl_translations_word_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_translations_words');


    }


  
  };
