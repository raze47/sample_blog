<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Posts;
use App\Models\User;

class Comments extends Model
{
    use HasFactory;
    public $timestamps = true;
    
    protected $fillable = [
        'content',
        'post_id',
        'user_id'
        
    ];

    public function posts(){
        return $this->belongsTo(Posts::class);
    }

    public function user(){
       return $this->belongsTo(User::class);
    }
}
