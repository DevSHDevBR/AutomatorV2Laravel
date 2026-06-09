<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_routes_access', function (Blueprint $table) {

        $table->id('tbl_routes_access_ID');

        $table->foreignId('tbl_users_type_ID')
              ->constrained('tbl_users_types', 'tbl_users_type_ID')
              ->cascadeOnDelete();

        $table->foreignId('tbl_sys_route_ID')
              ->constrained('tbl_sys_routes', 'tbl_sys_route_ID')
              ->cascadeOnDelete();

        $table->timestamp('tbl_routes_access_created_at')->useCurrent();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_routes_access');
    

    }
  


  };
