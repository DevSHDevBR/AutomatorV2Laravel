<?php


  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration {



    /**
     * Run the migrations.
     */
    public function up(): void {
      

      Schema::create('tbl_users', function (Blueprint $table) {

        $table->id('tbl_user_ID');
        $table->string('tbl_user_login', 100)->unique();
        $table->string('tbl_user_name', 100);
        $table->string('tbl_user_email')->unique();
        $table->string('tbl_user_password');
        $table->timestamp('tbl_user_email_verified_at')->nullable();
        $table->enum('tbl_user_status', ['ativo', 'inativo'])->default('ativo');
        $table->boolean('tbl_user_blocked')->default(false);
        $table->boolean('tbl_user_actived')->default(false);
        $table->timestamp('tbl_user_created_at')->useCurrent();
        $table->timestamp('tbl_user_updated_at')->nullable()->useCurrentOnUpdate();
        $table->timestamp('tbl_user_deleted_at')->nullable()->index();
        $table->rememberToken();
      
      });


      Schema::create('tbl_users_password_reset_tokens', function (Blueprint $table) {

        $table->string('reset_token_email')->primary();
        $table->string('reset_token_token');
        $table->timestamp('tbl_users_password_reset_token_created_at')->useCurrent()->nullable();
      
      });


      Schema::create('tbl_users_sessions', function (Blueprint $table) {

        $table->string('id')->primary();

        $table->foreignId('user_id')
            ->nullable()
            ->index();

        $table->string('ip_address', 45)
            ->nullable();

        $table->text('user_agent')
            ->nullable();

        $table->longText('payload');

        $table->integer('last_activity')
            ->index();
        // $table->string('id')->primary();

        // $table->foreignId('user_id')
        //   ->constrained('tbl_users', 'tbl_user_ID')
        //   ->cascadeOnDelete();

        // $table->string('token', 255)->unique();
        // $table->string('ip_address', 45)->nullable();
        // $table->text('user_agent')->nullable();
        // $table->longText('payload');
        // $table->boolean('tbl_users_session_status')->default(true);
        // $table->integer('last_activity')->nullable();
        // $table->timestamp('tbl_users_session_created_at')->useCurrent();

      });


    }



    /**
     * Reverse the migrations.
     */
    public function down(): void {


      Schema::dropIfExists('tbl_users');
      Schema::dropIfExists('tbl_users_password_reset_tokens');
      Schema::dropIfExists('tbl_users_sessions');
    

    }



  };
