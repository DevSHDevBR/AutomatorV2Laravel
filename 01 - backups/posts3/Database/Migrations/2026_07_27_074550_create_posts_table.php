<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_posts', function (Blueprint $table) {
    
        $table->id('tbl_post_ID');

        $table->text('tbl_post_slug', 255);

        $table->string('tbl_post_title', 255);
        
        $table->text('tbl_post_content')->nullable();

        $table->text('tbl_post_featured_image')->nullable();

        $table->enum('tbl_post_status', ['lixeira', 'rascunho', 'publicado'])->default('rascunho');

        $table->enum('tbl_post_access', ['public', 'restrict'])->default('public');

        $table->foreignId('tbl_user_ID')
                ->constrained('tbl_users', 'tbl_user_ID')
                ->cascadeOnDelete();

        $table->timestamp('tbl_post_created_at')->useCurrent();
        $table->timestamp('tbl_post_updated_at')->nullable()->useCurrentOnUpdate();
    

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
    

      Schema::dropIfExists('tbl_posts');
    

    }



  };
