<?php

namespace OpenCFP\Domain\Model;

use Illuminate\Database\Eloquent\Builder;
use OpenCFP\Domain\Services\TalkFormatter;

class Talk extends Eloquent
{
    public function speaker()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'talk_id');
    }

    public function comments()
    {
        return $this->hasMany(TalkComment::class);
    }

    public function meta()
    {
        return $this->hasMany(TalkMeta::class, 'talk_id');
    }

    /**
     * Return a collection of recent talks
     *
     * @param Builder $query
     * @param         $admin_id
     * @param int     $limit
     *
     * @return array|Talk[]
     */
    public function scopeRecent(Builder $query, $admin_id, $limit = 10)
    {
        return $query
            ->orderBy('created_at')
            ->with(['favorites', 'meta'])
            ->take($limit)
            ->get()
            ->map(function ($talk) use ($admin_id) {
                return $this->createdFormattedOutput($talk, $admin_id);
            });
    }
    /**
     * Iterates over DBAL objects and returns a formatted result set
     *
     * @param  mixed   $talk
     * @param  integer $admin_user_id
     * @return array
     */
    public function createdFormattedOutput($talk, $admin_user_id, $userData = true)
    {
        $format = new TalkFormatter();
        $output = $format->createdFormattedOutput($talk, $admin_user_id, $userData);

        return $output;
    }
}
