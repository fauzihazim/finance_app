<?php

// namespace App\Models;

// // use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // use HasFactory;
    public $incrementing = false;
    protected $keyType = 'uuid';

    public function pockets() {
        return $this->hasMany(UserPocket::class);
    }
    public function incomes() {
        return $this->hasMany(Income::class);
    }
    public function expenses() {
        return $this->hasMany(Expense::class);
    }
}
