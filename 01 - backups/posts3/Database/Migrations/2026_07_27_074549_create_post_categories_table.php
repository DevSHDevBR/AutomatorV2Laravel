<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_post_categories', function (Blueprint $table) {
    
        $table->id('tbl_post_categorie_ID');

        $table->string('tbl_post_categorie_name', 255);

        $table->string('tbl_post_categorie_title', 255);
        
        $table->text('tbl_post_categorie_content')->nullable();

        $table->string('tbl_post_categorie_parent_id')->nullable();

        $table->enum('tbl_post_categorie_status', ['ativo', 'inativo'])->default('ativo');
        
        $table->integer('tbl_post_categorie_ordem');

        $table->enum('tbl_post_categorie_access', ['public', 'restrict'])->default('public');

        $table->foreignId('tbl_user_ID')
                ->constrained('tbl_users', 'tbl_user_ID')
                ->cascadeOnDelete();

        $table->timestamp('tbl_post_categorie_created_at')->useCurrent();
        $table->timestamp('tbl_post_categorie_updated_at')->nullable()->useCurrentOnUpdate();
    

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
    

      Schema::dropIfExists('tbl_post_categories');
    

    }



  };
