<?php
namespace App\Helpers;
use Illuminate\Http\UploadedFile;
use Curl, Auth;
use App\Models\Image;
class Imgur{

	public static function getClientId(){
		return config('imgur.client_id');
	}

	protected static function send(array $data, $method = 'post', $appendUrl = '')
	{
		$data = Curl::to('https://api.imgur.com/3/image' . $appendUrl)
			->withHeader('Authorization: Client-ID '. static::getClientId())
			->withData($data)
			->{$method}();
		return json_decode($data, true);
	}

	public static function upload(UploadedFile $file){
		$image = base64_encode(file_get_contents($file->path()));
		return static::send(['image' => $image]);
	}

	public static function save(UploadedFile $file)
	{
		$json = static::upload($file);
		if (!isset(
			$json['status'], 
			$json['success'], 
			$json['data']['deletehash'], 
			$json['data']['link'],
			$json['data']['id']
		)){
			return null;
		}
		//Ghi vào CSDL
		$userID = Auth::check() ? Auth::user()->id : 0;
		$data = $json['data'];
		Image::create([
			'id' => $data['id'],
			'link' => $data['link'],
			'deletehash' => $data['deletehash'],
			'api' => json_encode($json),
			'user_id' => $userID,
		]);
		return $data['link'];
	}

	public static function delete(Image $image)
	{
		static::send([], 'delete', '/'. $image->deletehash);
		return $image->delete();
	}
}