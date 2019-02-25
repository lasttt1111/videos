<?php
namespace App\Helpers;
use Curl;
class OneSignal
{

    public static function send(array $data)
    {
        $curl = Curl::to("https://onesignal.com/api/v1/notifications");
        $curl->withHeaders([
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . config('onesignal.api_key'),
        ]);

        $curl->withData(json_encode($data));
        return $curl->post();
    }

    public static function notify($channelID, $title = '', $url = '', $image = null)
    {
        $data = [
            'app_id' => config('onesignal.app_id'),
            'contents' => [
                'vi' => $title,
                'en' => $title,
            ],
            'filters' => [
                [
                    'field' => 'tag',
                    'key' => 'channel_' . $channelID,
                    'relation' => 'exists',
                ]
            ],
            'url' => $url,
        ];

        return json_decode(static::send($data), true);
    }
}