<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable  = [
      'link',
      'comment',
      'category_id',
      'status_id',
    ];
    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
