<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;



  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {


      Schema::create('tbl_sys_shortcodes', function (Blueprint $table) {
        
        $table->id('tbl_sys_shortcode_ID');
        $table->string('tbl_sys_shortcode_code', 255)->unique();
        $table->string('tbl_sys_shortcode_title', 255);
        $table->text('tbl_sys_shortcode_description')->nullable();
        $table->string('tbl_sys_shortcode_class', 255);
        $table->string('tbl_sys_shortcode_method', 255);
        $table->text('tbl_sys_shortcode_params')->nullable();
        $table->boolean('tbl_sys_shortcode_locked')->default(false);
        $table->timestamp('tbl_sys_shortcode_created_at')->useCurrent();
        $table->timestamp('tbl_sys_shortcode_updated_at')->nullable()->useCurrentOnUpdate();


      });
    

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {
      Schema::dropIfExists('tbl_sys_shortcodes');
    

    }
  


  };
