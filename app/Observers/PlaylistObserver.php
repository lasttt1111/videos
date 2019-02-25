<?php
namespace App\Observers;

use App\Models\Playlist;
class PlaylistObserver
{
    public function deleting(Playlist $playlist)
    {
        $playlist->video()->detach();
    }
}