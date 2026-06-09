<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_sys_menus_access', function (Blueprint $table) {

        $table->id('tbl_menus_access_ID');

        $table->foreignId('tbl_users_type_ID')
              ->constrained('tbl_users_types', 'tbl_users_type_ID')
              ->cascadeOnDelete();

        $table->foreignId('tbl_sys_menu_item_ID')
              ->constrained('tbl_sys_menus_items', 'tbl_sys_menu_item_ID')
              ->cascadeOnDelete();

        $table->timestamp('tbl_menus_access_created_at')->useCurrent();
          

      });
    

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_menus_access');


    }
  


  };
