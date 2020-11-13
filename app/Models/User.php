<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function firm()
    {
        return $this->belongsTo(Firm::class);
    }

    public function phone()
    {
        return $this->hasOne(Phone::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_user')->withPivot('name');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function productDetail()
    {
        return $this->hasOneThrough(ProductDetail::class, Product::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Project::class);
    }

}
