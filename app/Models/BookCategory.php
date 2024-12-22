<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookCategory extends Model
{
    protected $guarded= ["id"];
    
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
