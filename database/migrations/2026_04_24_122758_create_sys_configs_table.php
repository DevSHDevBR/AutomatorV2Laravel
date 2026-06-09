<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_configs', function (Blueprint $table) {

        $table->id('tbl_sys_config_ID');
        $table->string('tbl_sys_config_name', 255)->unique();
        $table->text('tbl_sys_config_description')->nullable();
        $table->text('tbl_sys_config_value')->nullable();
        $table->timestamp('tbl_sys_config_created_at')->useCurrent();
        $table->timestamp('tbl_sys_config_updated_at')->nullable()->useCurrentOnUpdate();

      });
    

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_configs');
    

    }
  


  };
