<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'uuid';

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function pocket() {
        return $this->belongsTo(UserPocket::class, 'pocket_id');
    }
}