<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    protected $appends = array('imagePath', 'createdAtHumanReadable', 'updatedAtHumanReadable');

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImagePathAttribute()
    {
        if($this->image)
            return asset('/storage/images/'.$this->image);
        else 
            return asset('/storage/images/default.jpg');
    }

    public function getCreatedAtHumanReadableAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getupdatedAtHumanReadableAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
