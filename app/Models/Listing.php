<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title','logo','company','location','website','email','tags','description','user_id'];

    public function scopeFilter($query, array $filters){

        if($filters['tag'] ?? false){
            return $query->where('tags', 'like', '%'. request('tag'). '%');
        }
        if($filters['search'] ?? false){
            return $query->where('title', 'like', '%'. request('search'). '%')
            ->orWhere('description', 'like', '%'. request('search'). '%')
            ->orWhere('tags', 'like', '%'. request('search'). '%');
        }
    }

    //Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
