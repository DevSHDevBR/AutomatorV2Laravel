<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {


    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_menus_items', function (Blueprint $table) {
          
        $table->id('tbl_sys_menu_item_ID');

        $table->foreignId('tbl_sys_menu_ID')
              ->constrained('tbl_sys_menus', 'tbl_sys_menu_ID')
              ->cascadeOnDelete();

        $table->string('tbl_sys_menu_item_index', 255)->nullable();
        $table->string('tbl_sys_menu_item_icon', 255)->nullable();
        $table->text('tbl_sys_menu_item_class')->nullable();
        $table->string('tbl_sys_menu_item_title', 255);
        $table->string('tbl_sys_menu_item_type', 50)->default('route');
        $table->unsignedBigInteger('tbl_sys_route_ID')->nullable();
        $table->text('tbl_sys_menu_item_link')->nullable();
        $table->text('tbl_sys_menu_item_props')->nullable();
        $table->enum('tbl_sys_menu_item_status', ['ativo', 'inativo'])->default('ativo');
        $table->string('tbl_sys_menu_item_parent_id')->nullable();
        $table->boolean('tbl_sys_menu_item_admin')->default(false);
        $table->boolean('tbl_sys_menu_item_locked')->default(false);
        $table->integer('tbl_sys_menu_item_ordem');
        $table->timestamp('tbl_sys_menu_item_created_at')->useCurrent();
        $table->timestamp('tbl_sys_menu_item_updated_at')->nullable()->useCurrentOnUpdate();
      
      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_sys_menus_items');
    

    }


  
  };
