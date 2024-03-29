<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id', 'photo_id', 'is_active'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime',];

    // Start Relationship
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    } //End Relationship

    public static function editUserById($id)
    {
        return User::findOrFail($id);
    }

    public function isAdmin()
    {
        if($this->role->name === 'Administrator' && $this->is_active === 1)
        {
            return true;
        } return false;
    }

    //Gravatar
    public function getGravatarAttribute()
    {
        $hash = md5(strtolower(trim($this->attributes['email']))) . "?d=mm&s=";

        return "http://www.gravatar.com/avatar/$hash";
    }

    public function photoPlaceholder()
    {
        return "http://placehold.it/60x60";
    }
}
