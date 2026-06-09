<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {
    


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_users_types_rels', function (Blueprint $table) {
      
        $table->id('tbl_users_types_rel_ID');
        
        $table->foreignId('tbl_user_ID')
          ->constrained('tbl_users', 'tbl_user_ID')
          ->cascadeOnDelete();

        $table->foreignId('tbl_users_type_ID')
          ->constrained('tbl_users_types', 'tbl_users_type_ID')
          ->cascadeOnDelete();

        $table->timestamp('tbl_users_types_rel_created_at')->useCurrent();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_users_types_rels');
    

    }
  


  };
