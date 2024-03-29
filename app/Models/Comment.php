<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
      "comment",
      "feedback_id",
      "created_by",
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
