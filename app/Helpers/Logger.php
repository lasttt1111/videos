<?php
namespace App\Helpers;
use Auth, Request;

use Illuminate\Contracts\Support\Arrayable;

use App\Models\Log;
class Logger{

    public static function log($level, $message = '', $url = null, $ip = null, $data = [])
    {
        if (is_null($url)){
            $url = route('site.watch', ['alias' => $data->title]);
        }

        if (is_null($ip)){
            $ip = Request::ip();
        }

        if ($data instanceof Arrayable){
            $data = $data->toArray();
        }

        $user = Auth::check() ? Auth::user()->id : 0;

        return Log::create([
            'level' => $level,
            'message' => $message,
            'url' => $url,
            'ip' => $ip,
            'user_id' => $user,
            'data' => json_encode($data),
        ]);

    }

    public static function __callStatic($name, $params)
    {
        static::log($name, ...$params);
    }
}