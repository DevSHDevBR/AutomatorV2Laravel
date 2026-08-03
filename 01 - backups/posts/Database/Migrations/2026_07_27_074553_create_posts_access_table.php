<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_posts_access', function (Blueprint $table) {
    
        $table->id('tbl_posts_access_ID');

        $table->foreignId('tbl_users_type_ID')
          ->constrained('tbl_users_types', 'tbl_users_type_ID')
          ->cascadeOnDelete();

        $table->foreignId('tbl_post_ID')
          ->constrained('tbl_posts', 'tbl_post_ID')
          ->cascadeOnDelete();
    

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
    

      Schema::dropIfExists('tbl_posts_access');
    

    }



  };
