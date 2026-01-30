<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class UserPocket extends Model
// {
//     use HasFactory;
//     public $incrementing = false;
//     protected $keyType = 'uuid';

//     public function user() {
//         return $this->belongsTo(User::class);
//     }
//     public function incomes() {
//         return $this->hasMany(Income::class, 'pocket_id');
//     }
//     public function expenses() {
//         return $this->hasMany(Expense::class, 'pocket_id');
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserPocket extends Model
{
    use HasFactory;

    // Primary key pakai UUID
    public $incrementing = false;
    protected $keyType = 'string'; // gunakan string, bukan 'uuid'

    // Field yang bisa diisi
    // protected $fillable = [
    //     'id',
    //     'user_id',
    //     'name',
    //     'initial_balance',
    // ];
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'balance', // atau initial_balance sesuai migration
    ];

    // Generate UUID otomatis saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Income
    public function incomes()
    {
        return $this->hasMany(Income::class, 'pocket_id');
    }

    // Relasi ke Expense
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'pocket_id');
    }
}