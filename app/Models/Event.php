<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['name','start_date','end_date','created_by'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
