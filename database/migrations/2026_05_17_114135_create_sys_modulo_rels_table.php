<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {
    


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_modulos_rels', function (Blueprint $table) {
        
        $table->id('tbl_sys_modulo_rel_ID');
        $table->string('tbl_sys_modulo_rel_name', 255);
        $table->unsignedBigInteger('tbl_sys_modulo_ID')->nullable();
        $table->string('tbl_sys_modulo_rel_table', 255);
        $table->string('tbl_sys_modulo_rel_column', 255);
        $table->string('tbl_sys_modulo_rel_value', 255);
        $table->timestamp('tbl_sys_modulo_rel_created_at')->useCurrent();
        $table->timestamp('tbl_sys_modulo_rel_updated_at')->nullable()->useCurrentOnUpdate();

      });
    

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_modulo_rels');
    

    }
  


  };
