<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_views', function (Blueprint $table) {

        $table->id('tbl_sys_view_ID');

        $table->string('tbl_sys_view_name', 255)->unique();

        $table->string('tbl_sys_view_title', 255);

        $table->text('tbl_sys_view_description')->nullable();

        $table->text('tbl_sys_view_directory')->nullable();

        $table->string('tbl_sys_view_file', 255);

        $table->text('tbl_sys_view_args')->nullable();

        $table->enum('tbl_sys_view_status', ['ativo', 'inativo'])->default('ativo');

        $table->boolean('tbl_sys_view_locked')->default(false);

        $table->timestamp('tbl_sys_view_created_at')->useCurrent();
        $table->timestamp('tbl_sys_view_updated_at')->nullable()->useCurrentOnUpdate();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      

      Schema::dropIfExists('tbl_sys_views');
    

    }
  


  };
