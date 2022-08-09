<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

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
        return $this->docmment->sex;
    }

    // tạo thêm thuộc tính address
    public function getAddressAttribute()
    {
        return $this->docmment->address;
    }

    // tạo thêm thuộc tính email
    public function getEmailAttribute()
    {
        return $this->docmment->email;
    }

    // tạo thêm thuộc tính phone
    public function getPhoneAttribute()
    {
        return $this->docmment->phone;
    }

    // tạo thêm thuộc tính date_working
    public function getDateWorkingAttribute()
    {
        return $this->docmment->date_working;
    }

    // tạo thêm thuộc tính date_off
    public function getDateOffAttribute()
    {
        return $this->docmment->date_off;
    }

    // tạo thêm thuộc tính image_path
    public function getImagePathAttribute()
    {
        return $this->docmment->image_path;
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
}
