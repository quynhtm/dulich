<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

//Home
Route::any('/', array('as' => 'site.home','uses' => 'SiteHomeController@index'));
Route::get('404.html',array('as' => 'site.page404','uses' =>'SiteHomeController@page404'));
Route::get('tim-kiem.html',array('as' => 'site.searchItems','uses' =>'SiteHomeController@searchItems'));
Route::match(['GET','POST'],'lien-he.html',array('as' => 'site.pageContact','uses' =>'SiteHomeController@pageContact'));

//Category
Route::get('{name}-{id}.html',array('as' => 'site.pageCategory','uses' =>'SiteHomeController@pageCategory'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');
Route::get('{catname}/{news_title}-{new_id}.html',array('as' => 'Site.pageDetailNew','uses' =>'SiteHomeController@pageDetailNew'))->where('catname', '[A-Z0-9a-z_\-]+')->where('news_title', '[A-Z0-9a-z_\-]+')->where('new_id', '[0-9]+');
Route::match(['GET','POST'],'tim-kiem.html',array('as' => 'site.pageSearch','uses' =>'SiteHomeController@pageSearch'));
//Video
Route::match(['GET','POST'],'video.html',array('as' => 'site.pageVideo','uses' =>'SiteHomeController@pageVideo'));
Route::match(['GET','POST'],'thu-vien-video/chi-tiet/{video_title}-{video_id}.html',array('as' => 'site.pageVideoDetail','uses' =>'SiteHomeController@pageVideoDetail'))->where('video_title', '[A-Z0-9a-z_\-]+')->where('video_id', '[0-9]+');

//Hinh anh
Route::match(['GET','POST'],'thu-vien-anh.html',array('as' => 'site.pageLibrary','uses' =>'SiteHomeController@pageLibrary'));
Route::match(['GET','POST'],'thu-vien-anh/chi-tiet/{image_title}-{image_id}.html',array('as' => 'site.pageLibraryDetail','uses' =>'SiteHomeController@pageLibraryDetail'))->where('image_title', '[A-Z0-9a-z_\-]+')->where('image_id', '[0-9]+');

//Lich su kien
Route::match(['GET','POST'],'lich-su-kien.html',array('as' => 'site.pageEvent','uses' =>'SiteHomeController@pageEvent'));
Route::match(['GET','POST'],'lich-su-kien/chi-tiet/{event_title}-{event_id}.html',array('as' => 'site.pageEventDetail','uses' =>'SiteHomeController@pageEventDetail'))->where('event_title', '[A-Z0-9a-z_\-]+')->where('event_id', '[0-9]+');

//Phong ban trung tam
Route::match(['GET','POST'],'don-vi-truc-thuoc/{department_alias}/{department_title}-{department_id}.html',array('as' => 'site.pageDepartment','uses' =>'SiteHomeController@pageDepartment'))->where('department_alias', '[A-Z0-9a-z_\-]+')->where('department_title', '[A-Z0-9a-z_\-]+')->where('department_id', '[0-9]+');
Route::match(['GET','POST'],'don-vi-truc-thuoc/chi-tiet/{department_title}-{department_id}.html',array('as' => 'site.pageDepartmentDetail','uses' =>'SiteHomeController@pageDepartmentDetail'))->where('department_title', '[A-Z0-9a-z_\-]+')->where('department_id', '[0-9]+');

//Captcha
Route::match(['GET','POST'], 'captcha', array('as' => 'site.linkCaptcha','uses' =>'SiteHomeController@linkCaptcha'));
Route::match(['GET','POST'], 'captchaCheckAjax', array('as' => 'site.captchaCheckAjax','uses' =>'SiteHomeController@captchaCheckAjax'));


//Tra cuu
Route::match(['GET','POST'], 'tra-cuu-van-bang-chung-chi.html', array('as' => 'tracuu.traCuuVanBangChungChi','uses' =>'TraCuuController@traCuuVanBangChungChi'));
Route::match(['GET','POST'], 'ajax-tra-cuu-van-bang-chung-chi', array('as' => 'tracuu.ajaxTraCuuVanBangChungChi','uses' =>'TraCuuController@ajaxTraCuuVanBangChungChi'));

Route::match(['GET','POST'], 'tra-cuu-diem-thi-nang-khieu.html', array('as' => 'tracuu.traCuuDiemThiNangKhieu','uses' =>'TraCuuController@traCuuDiemThiNangKhieu'));
Route::match(['GET','POST'], 'ajax-tra-cuu-diem-thi-nang-khieu', array('as' => 'tracuu.ajaxTraCuuDiemThiNangKhieu','uses' =>'TraCuuController@ajaxTraCuuDiemThiNangKhieu'));

Route::match(['GET','POST'], 'tra-cuu-ket-qua-tuyen-sinh.html', array('as' => 'tracuu.traCuuXetTuyenSinh','uses' =>'TraCuuController@traCuuXetTuyenSinh'));
Route::match(['GET','POST'], 'ajax-tra-cuu-ket-qua-tuyen-sinh', array('as' => 'tracuu.ajaxTraCuuXetTuyenSinh','uses' =>'TraCuuController@ajaxTraCuuXetTuyenSinh'));



