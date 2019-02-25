<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace' => 'Site', 'as' => 'site.'], function(){

    Route::get('', ['uses' => 'HomeController@getIndex', 'as' => 'index']);
    //Video
    Route::get('watch/{alias}', ['uses' => 'VideoController@getWatch', 'as' => 'watch']);
    Route::get('watch/{alias}/link', ['uses' => 'VideoController@getLink', 'as' => 'link']);

    Route::post('watch/{alias}', ['uses' => 'VideoController@postWatch']);

    Route::post('watch/{alias}/reaction', ['uses' => 'VideoController@postReaction', 'middleware' => 'auth', 'as' => 'reaction']);

    // -- Chỉnh sửa video:
    //Route::get('edit/{alias}', ['uses' => 'UploadController@getEdit', 'as' => 'edit', 'middleware' => 'auth']);
    //Route::put('edit/{alias}', ['uses' => 'UploadController@putEdit', 'middleware' => 'auth']);
    //Route::delete('delete/{alias}', ['uses' => 'UploadController@delete', 'middleware' => 'auth', 'as' => 'delete']);

    //User:
    Route::group(['as' => 'user.', 'prefix' => 'user'], function(){
        Route::get('/', ['uses' => 'UserController@getProfile', 'as' => 'index']);
        Route::get('/{alias}', ['uses' => 'UserController@getProfile', 'as' => 'profile']);

        Route::get('{alias}/info', ['uses' => 'UserController@getInfo', 'as' => 'info', 'middleware' => 'auth']);
        Route::put('{alias}/info', ['uses' => 'UserController@putInfo', 'middleware' => 'auth']);

        Route::get('{alias}/playlist', ['uses' => 'UserController@getPlaylist', 'as' => 'playlist']);

        Route::get('{alias}/subscription', ['uses' => 'UserController@getSubscription', 'as' => 'subscription']);

        Route::post('{alias}/subscribe', ['uses' => 'UserController@postSubscribe', 'middleware' => 'auth', 'as' => 'subscribe']);
    });
    
    //Playlist
    Route::group(['prefix' => 'playlist', 'as' => 'playlist.'], function(){
        Route::get('/', ['uses' => 'PlaylistController@getIndex', 'as' => 'index']);
        Route::get('/{alias}', ['uses' => 'PlaylistController@getPlaylist', 'as' => 'playlist']);

        Route::get('search/name', ['uses' => 'PlaylistController@getSearch', 'as' => 'search']);
        Route::post('addto/{alias}', ['uses' => 'PlaylistController@postAddTo', 'as' => 'addto', 'middleware' => 'auth']);
    });

    Route::get('auth/login', ['uses' => 'UserController@getLogin', 'as' => 'login']);
    Route::get('auth/logout', ['uses' => 'UserController@getLogout', 'as' => 'logout']);

    //Danh mục:
    Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
        Route::get('/', ['uses' => 'CategoryController@getIndex', 'as' => 'index']);
        Route::get('/{alias}', ['uses' => 'CategoryController@getInfo', 'as' => 'category']);
    });

    //Thẻ:
    Route::group(['prefix' => 'tag', 'as' => 'tag.'], function(){
        //Route::get('/', ['uses' => 'TagController@getIndex', 'as' => 'index']);
        Route::get('/{alias}', ['uses' => 'TagController@getInfo', 'as' => 'info']);
    });
    
    //Tải lên:
    Route::group(['prefix' => 'upload', 'as' => 'upload.', 'middleware' => 'auth'], function(){
        //Video
        Route::group(['prefix' => 'video', 'as' => 'video.'], function(){
            Route::get('', ['uses' => 'UploadVideoController@getUpload', 'as' => 'add']);
            Route::post('', ['uses' => 'UploadVideoController@postUpload']);

            Route::get('/edit/{alias}', ['uses' => 'UploadVideoController@getEdit', 'as' => 'edit']);
            Route::put('/edit/{alias}', ['uses' => 'UploadVideoController@putEdit']);

            //Route::get('/delete/{alias}', ['uses' => 'UploadVideoController@getDelete', 'as' => 'delete']);
            Route::delete('/delete/{alias}', ['uses' => 'UploadVideoController@delete', 'as' => 'delete']);

        });
        
        //Danh sách phát:
        Route::group(['prefix' => 'playlist', 'as' => 'playlist.', 'middleware' => 'auth'], function(){
            Route::get('', ['uses' => 'UploadPlaylistController@getUpload', 'as' => 'add']);
            Route::post('', ['uses' => 'UploadPlaylistController@postUpload']);

            Route::get('/edit/{alias}', ['uses' => 'UploadPlaylistController@getEdit', 'as' => 'edit']);
            Route::put('/edit/{alias}', ['uses' => 'UploadPlaylistController@putEdit']);

            Route::delete('/delete/{alias}', ['uses' => 'UploadPlaylistController@delete', 'as' => 'delete']);

            Route::get('/search', ['uses' => 'UploadPlaylistController@getSearch', 'as' => 'search']);

            Route::post('/addto/{alias?}', ['uses' => 'UploadPlaylistController@postAddTo', 'as' => 'addto']);

        });
    });

    //Upload:
    //Route::get('upload/video', ['uses' => 'UploadController@getUpload', 'middleware' => 'auth', 'as' => 'upload']);
    //Route::post('upload/video', ['uses' => 'UploadController@postUpload', 'middleware' => 'auth']);



    //Thêm mới playlist
    //Route::get('upload/playlist', ['uses' => 'PlaylistController@getUpload', 'middleware' => 'auth', 'as' => 'upload.playlist']);
    //Route::post('upload/playlist', ['uses' => 'PlaylistController@postUpload', 'middleware' => 'auth']);

    //Danh sách video:
    Route::get('video', ['uses' => 'VideoController@getIndex', 'as' => 'video']);
    //Tìm kiếm
    Route::get('search', ['uses' => 'VideoController@getSearch', 'as' => 'search']);
    //Báo cáo:
    Route::get('report/{alias}', ['uses' => 'ReportController@getReport', 'as' => 'report', 'middleware' => 'auth']);
    Route::post('report/{alias}', ['uses' => 'ReportController@postReport', 'middleware' => 'auth']);

    //Ngôn ngữ:
    Route::get('language/{id}', ['uses' => 'LanguageController@setLanguage', 'as' => 'language']);

    //Đăng nhập:
    Route::get('login', ['uses' => 'UserController@getLogin', 'as' => 'login']);
    Route::post('post/login', ['uses' => 'UserController@postLogin', 'as' => 'postLogin']);
    Route::post('payment/{alias}', ['uses' => 'PaymentController@postPayment', 'as' => 'pay', 'middleware' => 'auth']);
    Route::get('payment/check/{alias}', ['uses' => 'PaymentController@checkPayment', 'as' => 'pay.check', 'middleware' => 'auth']);

    //Đăng ký:
    Route::get('register', ['uses' => 'UserController@getRegister', 'as' => 'register']);
    Route::post('post/register', ['uses' => 'UserController@postRegister', 'as' => 'postRegister']);
});


Route::group(['prefix' => 'quan-tri', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function (){
    Route::get('', ['uses' => 'HomeController@getIndex', 'as' => 'index']);

    //Thành viên
    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'admin.only'], function(){
        Route::get('/', ['uses' => 'UserController@getIndex', 'as' => 'index']);

        Route::get('info/{alias}', ['uses' => 'UserController@getInfo', 'as' => 'info']);

        Route::get('edit/{alias}', ['uses' => 'UserController@getEdit', 'as' => 'edit']);
        Route::put('edit/{alias}', ['uses' => 'UserController@putEdit']);

        Route::get('delete/{alias}', ['uses' => 'UserController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{alias}', ['uses' => 'UserController@delete']);
    });

    //Video
    Route::group(['prefix' => 'video', 'as' => 'video.'], function(){
        Route::get('/', ['uses' => 'VideoController@getIndex', 'as' => 'index']);

        Route::get('add', ['uses' => 'VideoController@getAdd', 'as' => 'add']);
        Route::post('add', ['uses' => 'VideoController@postVideo']);

        Route::get('edit/{alias}', ['uses' => 'VideoController@getEdit', 'as' => 'edit']);
        Route::put('edit/{alias}', ['uses' => 'VideoController@putEdit']);

        Route::get('delete/{alias}', ['uses' => 'VideoController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{alias}', ['uses' => 'VideoController@delete']);
    });
    //Playlist:
    Route::group(['prefix' => 'playlist', 'as' => 'playlist.'], function(){
        Route::get('/', ['uses' => 'PlaylistController@getIndex', 'as' => 'index']);

        Route::get('video', ['uses' => 'PlaylistController@getVideo', 'as' => 'search']);

        Route::get('add', ['uses' => 'PlaylistController@getAdd', 'as' => 'add']);
        Route::post('add', ['uses' => 'PlaylistController@postAdd']);

        Route::get('edit/{alias}', ['uses' => 'PlaylistController@getEdit', 'as' => 'edit']);
        Route::put('edit/{alias}', ['uses' => 'PlaylistController@putEdit']);

        Route::get('delete/{alias}', ['uses' => 'PlaylistController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{alias}', ['uses' => 'PlaylistController@delete']);
    });
    //Danh mục
    Route::group(['prefix' => 'category', 'as' => 'category.'], function(){
        Route::get('/', ['uses' => 'CategoryController@getIndex', 'as' => 'index']);

        Route::get('info/{alias}', ['uses' => 'CategoryController@getInfo', 'as' => 'info']);

        Route::get('add', ['uses' => 'CategoryController@getAdd', 'as' => 'add']);
        Route::post('add', ['uses' => 'CategoryController@postAdd']);

        Route::get('edit/{alias}', ['uses' => 'CategoryController@getEdit', 'as' => 'edit']);
        Route::put('edit/{alias}', ['uses' => 'CategoryController@putEdit']);

        Route::get('delete/{alias}', ['uses' => 'CategoryController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{alias}', ['uses' => 'CategoryController@delete']);
    });


    Route::group(['prefix' => 'tag', 'as' => 'tag.'], function(){
        Route::get('/', ['uses' => 'TagController@getIndex', 'as' => 'index']);

        Route::get('info/{alias}', ['uses' => 'TagController@getInfo', 'as' => 'info']);

        Route::get('add', ['uses' => 'TagController@getAdd', 'as' => 'add']);
        Route::post('add', ['uses' => 'TagController@postAdd']);

        Route::get('edit/{alias}', ['uses' => 'TagController@getEdit', 'as' => 'edit']);
        Route::put('edit/{alias}', ['uses' => 'TagController@putEdit']);

        Route::get('delete/{alias}', ['uses' => 'TagController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{alias}', ['uses' => 'TagController@delete']);
    });


    //Ngôn ngữ
    Route::group(['prefix' => 'language', 'as' => 'language.', 'middleware' => 'admin.only'], function(){
        Route::get('/', ['uses' => 'LanguageController@getIndex', 'as' => 'index']);

        Route::get('/info/{alias}', ['uses' => 'LanguageController@getInfo', 'as' => 'info']);
        Route::put('/info/{alias}', ['uses' => 'LanguageController@putInfo', 'as' => 'info']);

        Route::get('add', ['uses' => 'LanguageController@getAdd', 'as' => 'add']);
        Route::post('add', ['uses' => 'LanguageController@postAdd']);

        Route::get('edit/{alias}', ['uses' => 'LanguageController@getEdit', 'as' => 'edit']);
        Route::put('edit/{alias}', ['uses' => 'LanguageController@putEdit']);

        Route::get('delete/{alias}', ['uses' => 'LanguageController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{alias}', ['uses' => 'LanguageController@delete']);
        //Tải xuống
        Route::get('download/{alias}', ['uses' => 'LanguageController@getDownload', 'as' => 'download']);
        //Tải lên file ngôn ngữ
        Route::get('upload', ['uses' => 'LanguageController@getUpload', 'as' => 'upload']);
        Route::post('upload', ['uses' => 'LanguageController@postUpload']);
    });

    //Hình ảnh:
    Route::group(['prefix' => 'image', 'as' => 'image.', 'middleware' => 'admin.only'], function(){
        Route::get('/', ['uses' => 'ImageController@getIndex', 'as' => 'index']);

        Route::get('/{id}', ['uses' => 'ImageController@getInfo', 'as' => 'info']);

        Route::get('delete/{id}', ['uses' => 'ImageController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{id}', ['uses' => 'ImageController@delete']);
    });

    //Báo cáo:
    Route::group(['prefix' => 'report', 'as' => 'report.'], function(){
        Route::get('/', ['uses' => 'ReportController@getIndex', 'as' => 'index']);

        Route::get('/{id}', ['uses' => 'ReportController@getInfo', 'as' => 'info']);

        Route::get('delete/{id}', ['uses' => 'ReportController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{id}', ['uses' => 'ReportController@delete']);
    });

    //Nhật kí
    Route::group(['prefix' => 'log', 'as' => 'log.', 'middleware' => 'admin.only'], function(){
        Route::get('/', ['uses' => 'LogController@getIndex', 'as' => 'index']);

        Route::get('/{id}', ['uses' => 'LogController@getInfo', 'as' => 'info']);

        Route::get('delete/{id}', ['uses' => 'LogController@getDelete', 'as' => 'delete']);
        Route::delete('delete/{id}', ['uses' => 'LogController@delete']);
    });
});