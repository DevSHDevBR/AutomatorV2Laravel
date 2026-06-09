<?php


  namespace App\Models;

  // use Illuminate\Contracts\Auth\MustVerifyEmail;
  use Database\Factories\UserFactory;
  use Illuminate\Database\Eloquent\Attributes\Fillable;
  use Illuminate\Database\Eloquent\Attributes\Hidden;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use App\Models\UsersType;
  use App\Models\UsersSession;

  
  class User extends Authenticatable {



    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    protected $table      = 'tbl_users';
    protected $primaryKey = 'tbl_user_ID';

    const CREATED_AT = 'tbl_user_created_at';
    const UPDATED_AT = 'tbl_user_updated_at';


    protected $fillable = [

      'tbl_user_login',
      'tbl_user_name',
      'tbl_user_password',
      'tbl_user_email',
      'tbl_user_status',
      'tbl_user_blocked',
      'tbl_user_actived'

    ];


    protected $hidden = [

      'tbl_user_password',
      'remember_token'

    ];


    protected $casts = [

      'tbl_user_blocked' => 'boolean',
      'tbl_user_actived' => 'boolean',

    ];



    public function getAuthPassword() {


      return $this->tbl_user_password;


    }



    public function getAuthIdentifierName() {

      return $this->primaryKey;

    }



    public function UserGetTypes() {

      return $this->belongsToMany(
        UsersType::class,
        'tbl_users_types_rels',
        'tbl_user_ID',
        'tbl_users_type_ID',
        'tbl_user_ID',
        'tbl_users_type_ID'
      );

    }



    public function UserGetTypesIDs() {


      return $this->UserGetTypes()->pluck('tbl_users_types.tbl_users_type_ID')->toArray();


    }



    public function UserHasType($typeID) {


      if (!$typeID) {

        return false;

      }

      
      return $this->UserGetTypes()->where('tbl_users_types.tbl_users_type_ID', $typeID)->exists();


    }



    public function UserHasTypeByName($typeName) {


      if (!$typeName) {

        return false;

      }


      return $this->UserGetTypes()->where('tbl_users_types.tbl_users_type_name', $typeName)->exists();


    }



    public function getUserSessions() {


      // return $this->hasMany(UsersSession::class, 'tbl_user_ID', 'tbl_user_ID');


    }



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
      

      return [

        'tbl_user_email_verified_at' => 'datetime',
        'tbl_user_password'          => 'hashed',

      ];
    

    }
  


  }
