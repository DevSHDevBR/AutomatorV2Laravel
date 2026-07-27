<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {
    


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_modulos', function (Blueprint $table) {
        
        $table->id('tbl_sys_modulo_ID');
        $table->string('tbl_sys_modulo_name', 255)->unique();
        $table->string('tbl_sys_modulo_title', 255);
        $table->text('tbl_sys_modulo_description')->nullable();
        $table->string('tbl_sys_modulo_version', 25);
        $table->boolean('tbl_sys_modulo_locked')->default(false);
        $table->enum('tbl_sys_modulo_status', ['ativo', 'inativo'])->default('ativo');
        $table->timestamp('tbl_sys_modulo_created_at')->useCurrent();
        $table->timestamp('tbl_sys_modulo_updated_at')->nullable()->useCurrentOnUpdate();

      });
    

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_modulos');
    

    }
  


  };
