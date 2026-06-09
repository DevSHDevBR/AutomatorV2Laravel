<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_routes', function (Blueprint $table) {

        $table->id('tbl_sys_route_ID');
        $table->string('tbl_sys_route_name', 255)->unique();
        $table->string('tbl_sys_route_title', 255);
        $table->text('tbl_sys_route_permalink')->nullable();
        $table->boolean('tbl_sys_route_api')->default(false);
        $table->boolean('tbl_sys_route_admin')->default(false);
        $table->boolean('tbl_sys_route_locked')->default(false);
        $table->string('tbl_sys_route_type', 15)->default('GET');
        $table->string('tbl_sys_route_controller', 255)->nullable();
        $table->string('tbl_sys_route_method', 255)->nullable();
        $table->text('tbl_sys_route_args')->nullable();
        $table->text('tbl_sys_route_content')->nullable();
        $table->text('tbl_sys_route_description')->nullable();
        $table->enum('tbl_sys_route_area', ['public', 'restrict'])->default('public');
        $table->enum('tbl_sys_route_status', ['ativo', 'inativo'])->default('ativo');
        $table->string('tbl_sys_route_parent_id') ->nullable();
        $table->timestamp('tbl_sys_route_created_at')->useCurrent();
        $table->timestamp('tbl_sys_route_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_routes');
    

    }
  


  };
