<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {
    


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_users_types', function (Blueprint $table) {

        $table->id('tbl_users_type_ID');
        $table->string('tbl_users_type_name', 255)->unique();
        $table->text('tbl_users_type_description')->nullable();
        $table->boolean('tbl_users_type_locked')->default(false);
        $table->enum('tbl_users_type_status', ['ativo', 'inativo'])->default('ativo');
        $table->timestamp('tbl_users_type_created_at')->useCurrent();
        $table->timestamp('tbl_users_type_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {

      
      Schema::dropIfExists('tbl_users_types');
    

    }



  };
