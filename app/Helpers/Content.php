<?php
namespace App\Helpers;
use Auth;
use App\Models\Video;
use App\Helpers\Logger;
use App\Models\Language;
class Content
{
    protected static $mode = 'site';

    protected static $module;

    protected static $data;

    protected static $viewData;

    protected static $channelList = null;

    protected static $languages = null;

    public static function render(array $data = [], int $status = 200){
        static::$viewData = $data + ['module' => static::$module];
        return view(static::$mode.'/template', static::$viewData);
    }

    public static function getMode(){
        return static::$mode;
    }

    public static function setMode($mode = 'site'){
        static::$mode = $mode;
    }

    public static function error(int $status, string $message = ''){
        if ($status != 404){
            Logger::error($message ? $message : $status);
        }
        return static::render([
            'module' => 'error', 
            'function' => $status, 
            'title' => $status,
            'message' => $message,
        ], 
        $status);
    }

    public static function setModule($module){
        static::$module = $module;
    }

    public static function formatReaction(\Illuminate\Database\Eloquent\Collection $collection){
        $result = [];
        foreach ($collection as $c){
            $result[$c->reaction] = $c->number;
        }
        return $result;
    }

    public static function setData($name, $value)
    {
        return static::$data[$name] = $value;
    }

    public static function getData($name)
    {
        return isset(static::$data[$name]) ? static::$data[$name] : null;
    }

    public static function isMod()
    {
        return Auth::check() && Auth::user()->permission < 3;
    }

    public static function getNewestVideo(int $number = 10)
    {
        return Video::where('privacy', 0)
                    ->with('user:id,alias,avatar,name')
                    ->limit($number)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    public static function getViewData()
    {
        return static::$viewData;
    }
    //Danh sách kênh (người dùng đăng kí)
    public static function renderChannelList()
    {
        if (!is_null(static::$channelList)){
            return static::$channelList;
        }

        $result = [];
        if (Auth::check()){
            $subscriptions = Auth::user()->subscription()->select(['id'])->get();
            foreach ($subscriptions as $sub) {
                $result['channel_' . $sub->id] = 1;
            }
        }
        return static::$channelList = $result;
    }

    public static function getLanguages(){
        if (is_null(static::$languages)){
            static::$languages = Language::all();
        }
        return static::$languages;
    }
}