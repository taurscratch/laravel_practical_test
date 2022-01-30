<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable =['name','phone','dob','gender','address'];

    public function Fields(){
        return $this->belongsToMany(Field::class)->withPivot('view');
    }
}
