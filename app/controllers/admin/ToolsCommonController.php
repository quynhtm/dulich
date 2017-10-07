<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class ToolsCommonController extends BaseAdminController
{
    private $permission_view = 'toolsCommon_view';
    private $permission_full = 'toolsCommon_full';
    private $permission_delete = 'toolsCommon_delete';
    private $permission_create = 'toolsCommon_create';
    private $permission_edit = 'toolsCommon_edit';

    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'lib/dragsort/jquery.dragsort.js',
            'js/common.js',
        ));
    }
    //cập nhật thêm quyền cho hệ thông
    public function addPermit(){
        //die();
        //die('tạm dừng chức năng này');
        $arrPermit = ArrayPermission::$arrPermit;

        /*DB::table('permission')->truncate();
        DB::table('group_user')->truncate();
        DB::table('group_user_permission')->truncate();*/
        foreach($arrPermit as $permit=> $infor){
            $arrInsert = array('permission_code'=>$permit,
                'permission_name'=>$infor['name_permit'],
                'permission_group_name'=>$infor['group_permit'],
                'permission_status'=>1);
            if (!Permission::checkExitsPermissionCode($permit)) {
                Permission::createPermission($arrInsert);
            }
        }
        FunctionLib::debug($arrPermit);
    }
}