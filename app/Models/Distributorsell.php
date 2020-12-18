<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributorsell extends Model
{
    use HasFactory;
    public function distributer(){
        return $this->belongsTo(Distributer::class);
    }
}
