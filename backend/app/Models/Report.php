<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $fillable = [
        'title','description','user_id'
    ];

    public function userDetails()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
