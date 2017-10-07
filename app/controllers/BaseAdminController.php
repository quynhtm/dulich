<?php
class BaseAdminController extends BaseController
{
    protected $layout = 'admin.AdminLayouts.index';
    protected $permission = array();
    protected $user = array();
    protected $is_root = false;
    protected $is_boss = false;
    protected $user_group_depart = '';

    public function __construct()
    {
        if (!User::isLogin()) {
            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        FunctionLib::link_js(array(
            'lib/jAlert/jquery.alerts.js',
        ));
        FunctionLib::link_css(array(
            'lib/jAlert/jquery.alerts.css',
        ));

        $this->user = User::user_login();
        if($this->user){
            if(sizeof($this->user['user_permission']) > 0) {
                $this->permission = $this->user['user_permission'];
            }
            $this->user_group_depart = $this->user['user_group_depart'];
        }
        //FunctionLib::debug($this->user);
        //boss admin
        if(in_array('is_boss',$this->permission)){
            $this->is_boss = true;
        }
        //quản trị viên
        if(in_array('root',$this->permission)){
            $this->is_root = true;
        }
        $menu = $this->menu();
        View::share('menu',$menu);
        View::share('aryPermission',$this->permission);
        View::share('user',$this->user);
        View::share('user_group_depart',$this->user_group_depart);
        View::share('is_root',$this->is_root);
        View::share('is_boss',$this->is_boss);
    }

    public function menu(){
        $menu[] = array(
            'name'=>'QL người dùng',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-user',
            'arr_link_sub'=>array('admin.user_view','admin.permission_view','admin.groupUser_view',),//dung de check menu left action
            'sub'=>array(
                array('name'=>'Tài khoản Admin', 'RouteName'=>'admin.user_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'user_view'),
                array('name'=>'Danh sách quyền', 'RouteName'=>'admin.permission_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>0,'showMenu'=>0, 'permission'=>'permission_full'),
                array('name'=>'Danh sách nhóm quyền', 'RouteName'=>'admin.groupUser_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>0,'showMenu'=>0, 'permission'=>'group_user_view'),
                array('name'=>'Type Setting', 'RouteName'=>'admin.typeSettingView', 'icon'=>'fa fa-wrench icon-4x', 'showcontent'=>0,'showMenu'=>0, 'permission'=>'setting_site_full'),
            ),
        );

        $menu[] = array(
            'name'=>'QL site',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-location-arrow',
            'arr_link_sub'=>array('admin.info','admin.contract','admin.attackLinkView'),
            'sub'=>array(
                array('name'=>'Liên kết link', 'RouteName'=>'admin.attackLinkView', 'icon'=>'fa fa-link icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'abc'),
                array('name'=>'Liên hệ quản trị', 'RouteName'=>'admin.contract', 'icon'=>'fa fa-envelope-o icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'contract_view'),
                array('name'=>'Thông tin chung', 'RouteName'=>'admin.info', 'icon'=>'fa fa-cogs icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'abc'),
            ),
        );

        $menu[] = array(
            'name'=>'QL Danh mục',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-gift',
            'arr_link_sub'=>array('admin.department_list','admin.category_list','admin.tabView','admin.tabSubView',),
            'sub'=>array(
                //array('name'=>'Khoa - Trung tâm', 'RouteName'=>'admin.department_list', 'icon'=>'fa fa-users icon-4x', 'showcontent'=>1, 'showMenu'=>1,'permission'=>'department_full'),
                array('name'=>'Danh mục tin', 'RouteName'=>'admin.category_list', 'icon'=>'fa fa-indent icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'category_full'),
                array('name'=>'Tab tuyển sinh-đào tạo', 'RouteName'=>'admin.tabView', 'icon'=>'fa fa-indent icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'tab_full'),
               // array('name'=>'Tab sub tuyển sinh-đào tạo', 'RouteName'=>'admin.tabSubView', 'icon'=>'fa fa-indent icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'tab_full'),
            ),
        );

        $menu[] = array(
            'name'=>'QL nội dung',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-book',
            'arr_link_sub'=>array('admin.newsView','admin.eventView','admin.bannerView','admin.videoView','admin.libraryImageView',),
            'sub'=>array(
                array('name'=>'Tin tức', 'RouteName'=>'admin.newsView', 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'news_full'),
                array('name'=>'Danh sách sự kiện', 'RouteName'=>'admin.eventView', 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'event_full'),
                array('name'=>'Banner quảng cáo', 'RouteName'=>'admin.bannerView', 'icon'=>'fa fa-globe icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'banner_full'),
                array('name'=>'Thư viện ảnh', 'RouteName'=>'admin.libraryImageView', 'icon'=>'fa fa-picture-o icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'libraryImage_full'),
                array('name'=>'Video', 'RouteName'=>'admin.videoView', 'icon'=>'fa fa-video-camera icon-4x', 'showcontent'=>1,'showMenu'=>1, 'permission'=>'video_full'),
            ),
        );
        return $menu;
    }

    public function getControllerAction(){
        return $routerName = Route::currentRouteName();
    }
}