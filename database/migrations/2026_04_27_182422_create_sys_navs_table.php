<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_navs', function (Blueprint $table) {

        $table->id('tbl_sys_nav_ID');
        $table->string('tbl_sys_nav_name', 255)->unique();
        $table->string('tbl_sys_nav_title', 255);
        $table->boolean('tbl_sys_nav_admin')->default(false);
        $table->boolean('tbl_sys_nav_locked')->default(false);
        $table->timestamp('tbl_sys_nav_created_at')->useCurrent();
        $table->timestamp('tbl_sys_nav_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_navs');


    }
  


  };
