<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "description",
        "category_id",
        "submit_by",
    ];
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'submit_by');
    }
}
