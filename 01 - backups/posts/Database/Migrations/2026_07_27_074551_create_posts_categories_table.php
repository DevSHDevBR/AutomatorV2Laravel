<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_posts_categories', function (Blueprint $table) {
    
        $table->id('tbl_posts_categories_ID');

        $table->foreignId('tbl_post_ID')
          ->constrained('tbl_posts', 'tbl_post_ID')
          ->cascadeOnDelete();

        $table->foreignId('tbl_post_categorie_ID')
          ->constrained('tbl_post_categories', 'tbl_post_categorie_ID')
          ->cascadeOnDelete();

        $table->timestamp('tbl_posts_categories_created_at')->useCurrent();
    

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
    

      Schema::dropIfExists('tbl_posts_categories');
    

    }



  };
