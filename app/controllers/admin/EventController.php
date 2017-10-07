<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class EventController extends BaseAdminController
{
    private $permission_view = 'event_view';
    private $permission_full = 'event_full';
    private $permission_delete = 'event_delete';
    private $permission_create = 'event_create';
    private $permission_edit = 'event_edit';
    private $arrStatus = array(CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');

    private $error = array();
    private $arrCategoryNew = array();
    private $arrTypeNew = array();
    private $arrDepart = array();

    public function __construct()
    {
        parent::__construct();

        $this->arrCategoryNew = Category::getOptionAllCategory();
        $this->arrTypeNew = CGlobal::$arrTypeNew;

        $userDepar = explode(',',$this->user_group_depart);
        $this->arrDepart = Department::getDepartWithUser($userDepar,$this->is_root);

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

    public function view() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['event_title'] = addslashes(Request::get('event_title',''));
        $search['event_status'] = (int)Request::get('event_status',-1);
        if(!$this->is_root){
            $search['string_depart_id'] = $this->user_group_depart;
        }

        //$search['field_get'] = 'category_id,news_title,news_status';//cac truong can lay
        $dataSearch = EventNew::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption(array(-1=>'----Chọn trạng thái----')+$this->arrStatus, $search['event_status']);

        $this->layout->content = View::make('admin.Event.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)

            ->with('arrDepart', $this->arrDepart)
            ->with('arrCategoryNew', $this->arrCategoryNew)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    public function getItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        $arrViewImgOther = array();
        $imageOrigin = $urlImageOrigin = '';
        if($id > 0) {
            $data = EventNew::getByID($id);
            if(sizeof($data) > 0){
                //lay ảnh khác của san phẩm
                $arrViewImgOther = array();
                if(!empty($data->event_image_other)){
                    $arrImagOther = unserialize($data->event_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            $url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_EVENT, $id, $val, CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false);
                            $arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb);
                        }
                    }
                }
                //ảnh sản phẩm chính
               $imageOrigin = $data->event_image;
            }
        }

        $optionDepart = FunctionLib::getOption(array(0=>'----Chọn khoa - trung tâm----')+$this->arrDepart, isset($data['event_depart_id'])? $data['event_depart_id'] : CGlobal::status_hide);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['event_status'])? $data['event_status'] : CGlobal::status_show);
        $optionTypeNew = FunctionLib::getOption($this->arrTypeNew, isset($data['event_type'])? $data['event_type'] : CGlobal::NEW_TYPE_TIN_TUC);
        $this->layout->content = View::make('admin.Event.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('imageOrigin', $imageOrigin)
            ->with('urlImageOrigin', $urlImageOrigin)
            ->with('arrViewImgOther', $arrViewImgOther)
            ->with('optionDepart', $optionDepart)
            ->with('optionTypeNew', $optionTypeNew)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus);
    }
    public function postItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $dataSave['event_title'] = addslashes(Request::get('event_title'));
        $dataSave['event_desc_sort'] = addslashes(Request::get('event_desc_sort'));
        $dataSave['event_content'] = FunctionLib::strReplace(Request::get('event_content'), '\r\n', '');

        $dataSave['event_status'] = (int)Request::get('event_status', 0);
        $dataSave['event_order'] = (int)Request::get('event_order', 1);
        $dataSave['event_type'] = (int)Request::get('event_type', CGlobal::NEW_TYPE_TIN_TUC);
        $dataSave['event_time_start'] = Request::get('event_time_start');
        $dataSave['event_time_end'] = Request::get('event_time_end');

        $dataSave['event_depart_id'] = (int)Request::get('event_depart_id', CGlobal::status_hide);
        $id_hiden = (int)Request::get('id_hiden', 0);
		
        //ảnh chính
        $image_primary = addslashes(Request::get('image_primary'));
        //ảnh khác
        $getImgOther = Request::get('img_other',array());
        if(!empty($getImgOther)){
            foreach($getImgOther as $k=>$val){
                if($val !=''){
                    $arrInputImgOther[] = $val;
                }
            }
        }
        if (!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
            //nếu không chọn ảnh chính, lấy ảnh chính là cái đầu tiên
            $dataSave['event_image'] = ($image_primary != '')? $image_primary: $arrInputImgOther[0];
            $dataSave['event_image_other'] = serialize($arrInputImgOther);
        }

        //FunctionLib::debug($dataSave);
        if($this->valid($dataSave) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            $dataSave['event_time_start'] = ($dataSave['event_time_start'] != '')?strtotime($dataSave['event_time_start']):0;
            $dataSave['event_time_end'] = ($dataSave['event_time_end'] != '')?strtotime($dataSave['event_time_end']):0;
            if($id > 0){
                //cap nhat
                if(EventNew::updateData($id, $dataSave)) {
                    return Redirect::route('admin.eventView');
                }
            } else {
                //them moi
                if(EventNew::addData($dataSave)) {
                    return Redirect::route('admin.eventView');
                }
            }
        }
        $optionDepart = FunctionLib::getOption(array(0=>'----Chọn khoa - trung tâm----')+$this->arrDepart, isset($dataSave['event_depart_id'])? $dataSave['event_depart_id'] : CGlobal::status_hide);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['event_status'])? $dataSave['event_status'] : -1);
        $optionTypeNew = FunctionLib::getOption($this->arrTypeNew, isset($dataSave['event_type'])? $dataSave['event_type'] : CGlobal::NEW_TYPE_TIN_TUC);
        $dataSave['event_time_start'] = strtotime($dataSave['event_time_start']);
        $dataSave['event_time_end'] = strtotime($dataSave['event_time_end']);
        $this->layout->content =  View::make('admin.Event.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionDepart', $optionDepart)
            ->with('optionTypeNew', $optionTypeNew)
            ->with('error', $this->error)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteEvent(){
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && EventNew::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['category_name']) && $data['category_name'] == '') {
                $this->error[] = 'Tên danh mục không được trống';
            }
            if(isset($data['category_status']) && $data['category_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái cho danh mục';
            }
            return true;
        }
        return false;
    }

    //ajax
    public function updateStatusEvent()
    {
        $id = (int)Request::get('id', 0);
        $category_status = (int)Request::get('status', CGlobal::status_hide);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            $dataSave['event_status'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
            if(EventNew::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }
}