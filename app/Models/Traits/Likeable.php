<?php

namespace App\Models\Traits;

use App\Models\Like;
use Illuminate\Support\Facades\Auth;

trait Likeable
{
    public function like()
    {
        $like = new Like(['user_id' => Auth::id()]);

        $this->likes()->save($like);
    }

    public function unlike()
    {
        $this->likes()->where('user_id', Auth::id())->delete();
    }

    public function toggle()
    {
        if ($this->isLiked()) {
            $this->unlike();
            return;
        }

        $this->like();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function isLiked()
    {
        return (bool)$this->likes()->where('user_id', Auth::id())->count();
    }

    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }
}
