<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\EncryptableTrait;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use EncryptableTrait;
    public $encryptable = ['email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // tạo thêm thuộc tính sex
    public function getSexAttribute()
    {
        return $this->docmments()->first()->sex ?? 0;
    }

    // tạo thêm thuộc tính description
    public function getDescriptionAttribute()
    {
        return $this->docmments()->first()->description ?? '';
    }

    // tạo thêm thuộc tính content
    public function getContentAttribute()
    {
        return $this->docmments()->first()->content ?? '';
    }

    // tạo thêm thuộc tính date_working
    public function getDateWorkingAttribute()
    {
        return $this->docmments()->first()->date_working ?? '';
    }

    // tạo thêm thuộc tính date_off
    public function getDateOffAttribute()
    {
        return $this->docmments()->first()->date_off ?? '';
    }

    // tạo thêm thuộc tính image_path
    public function getImagePathAttribute()
    {
        return $this->docmments()->first()->image_path ?? '';
    }

    public function docmments()
    {
        return $this->hasMany(Documment::class, "user_id", "id");
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, CategoryUser::class, 'user_id', 'category_id')
            ->withTimestamps();
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function district()
    {
        return  $this->belongsTo(Distrist::class, 'district_id', 'id');
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class, "user_id", "id");
    }
}
