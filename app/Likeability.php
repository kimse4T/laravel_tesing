<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use App\Models\Like;

/**
 *
 */
trait Likeability
{
    public function likes()
    {
        return $this->morphMany('App\Models\Like','likeable');
    }

    public function like()
    {
        $like = new Like(['user_id'=>Auth::id()]);

        $this->likes()->save($like);
    }

    public function unlike()
    {
        $this->likes()->where('user_id',Auth::id())->delete();
    }

    public function isLiked()
    {
        return !! $this->likes()->where('user_id',Auth::id())->count();
    }

    public function toggle()
    {
        if($this->isLiked()){
            return $this->unlike();
        }
        return $this->isLiked();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
}


?>
