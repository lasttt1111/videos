<?php
namespace App\Observers;

use App\Models\Video;

use App\Helpers\Logger;
use App\Models\Notification;

use App\Helpers\OneSignal;
class VideoObserver
{
    public function created(Video $video)
    {
        //Bắt sự kiện tạo:
        //1. Gửi thông báo đi
        Logger::info(__('Video được tải lên'), null, null, $video);
        OneSignal::notify($video->user_id, $video->title, route('site.watch', ['alias' => $video->alias]));
    }
    //Loại bỏ
    public function deleting(Video $video)
    {
        $video->playlists()->detach();
        $video->tags()->detach();
        Logger::info(__('Xóa bỏ video'), null, null, $video);
    }
}