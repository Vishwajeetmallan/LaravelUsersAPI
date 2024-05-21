<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $cypher = "aes-128-gcm";
    protected $key = 'abc1234';
    protected $tag = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

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

    /**
     * create mutator to encrypt value while inserting
     */
    public function setEmailAttribute($value) {
        $ivlen = openssl_cipher_iv_length($this->cypher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $this->attributes['email'] = base64_encode($value);
    }

    /**
     * create accessor to decrypt values while selecting
     */
    public function getEmailAttribute($value) {
        $ivlen = openssl_cipher_iv_length($this->cypher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        return base64_decode($value);
        // return $value;
    }

    /**
     * accessor for phone number
     */
    public function getPhoneAttribute($value) {
        return substr($value, 0,2).'******'.substr($value, strlen($value)-2, strlen($value)-1);
    }
}
