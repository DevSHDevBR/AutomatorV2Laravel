<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_menus', function (Blueprint $table) {

        $table->id('tbl_sys_menu_ID');
        $table->unsignedBigInteger('tbl_sys_nav_ID')->nullable();
        $table->string('tbl_sys_menu_title', 255);
        $table->string('tbl_sys_menu_index', 255)->nullable();
        $table->text('tbl_sys_menu_class')->nullable();
        $table->boolean('tbl_sys_menu_locked')->default(false);
        $table->timestamp('tbl_sys_menu_created_at')->useCurrent();
        $table->timestamp('tbl_sys_menu_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_menus');
    

    }



  };
