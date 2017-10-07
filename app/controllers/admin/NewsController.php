<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class NewsController extends BaseAdminController
{
    private $permission_view = 'news_view';
    private $permission_full = 'news_full';
    private $permission_delete = 'news_delete';
    private $permission_create = 'news_create';
    private $permission_edit = 'news_edit';
    private $arrStatus = array(CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrCommonPage = array(CGlobal::status_hide => 'Tin tức riêng', CGlobal::status_show => 'Tin tức chung');
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

        $search['news_title'] = addslashes(Request::get('news_title',''));
        $search['news_status'] = (int)Request::get('news_status',-1);
        if(!$this->is_root){
            $search['string_depart_id'] = $this->user_group_depart;
        }

        //$search['field_get'] = 'category_id,news_title,news_status';//cac truong can lay
        $dataSearch = News::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption(array(-1=>'----Chọn trạng thái----')+$this->arrStatus, $search['news_status']);
        $this->layout->content = View::make('admin.News.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('arrDepart', $this->arrDepart)
            ->with('arrTypeNew', $this->arrTypeNew)
            ->with('arrCategoryNew', $this->arrCategoryNew)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    public function getNews($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        $arrViewImgOther = array();
        $imageOrigin = $urlImageOrigin = '';
        if($id > 0) {
            $data = News::getNewByID($id);
            if(sizeof($data) > 0){
                //lay ảnh khác của san phẩm
                $arrViewImgOther = array();
                if(!empty($data->news_image_other)){
                    $arrImagOther = unserialize($data->news_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            $url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_NEWS, $id, $val, CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false);
                            $arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb);
                        }
                    }
                }
                //ảnh sản phẩm chính
               $imageOrigin = $data->news_image;
            }
        }

        $optionDepart = FunctionLib::getOption(array(0=>'----Chọn khoa - trung tâm (Trang chủ)----')+$this->arrDepart, isset($data['news_depart_id'])? $data['news_depart_id'] : CGlobal::status_hide);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['news_status'])? $data['news_status'] : CGlobal::status_show);
        $optionCommonPage = FunctionLib::getOption($this->arrCommonPage, isset($data['news_common_page'])? $data['news_common_page'] : CGlobal::status_hide);
        $optionTypeNew = FunctionLib::getOption($this->arrTypeNew, isset($data['news_type'])? $data['news_type'] : CGlobal::NEW_TYPE_TIN_TUC);

        $arrCategory = (isset($data->news_depart_id))? Category::buildOptionCategoryNew($data->news_depart_id):array();
        $arrCategory = !empty($arrCategory)? $arrCategory :array(0=>'----Chọn danh mục tin----');
        $optionCategory = FunctionLib::getOption($arrCategory, isset($data['news_category_id'])? $data['news_category_id'] : CGlobal::status_hide);
        $optionCategoryShow = FunctionLib::getOption($arrCategory, isset($data['news_show_cate_id'])? $data['news_show_cate_id'] : CGlobal::status_hide);

        $this->layout->content = View::make('admin.News.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('imageOrigin', $imageOrigin)
            ->with('urlImageOrigin', $urlImageOrigin)
            ->with('arrViewImgOther', $arrViewImgOther)
            ->with('optionDepart', $optionDepart)
            ->with('optionCommonPage', $optionCommonPage)
            ->with('optionStatus', $optionStatus)
            ->with('optionTypeNew', $optionTypeNew)
            ->with('optionCategory', $optionCategory)
            ->with('optionCategoryShow', $optionCategoryShow)
            ->with('arrStatus', $this->arrStatus);
    }
    public function postNews($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $dataSave['news_title'] = addslashes(Request::get('news_title'));
        $dataSave['news_desc_sort'] = addslashes(Request::get('news_desc_sort'));
        $dataSave['news_content'] = FunctionLib::strReplace(Request::get('news_content'), '\r\n', '');
        $dataSave['news_type'] = addslashes(Request::get('news_type',CGlobal::NEW_TYPE_TIN_TUC));
        $dataSave['news_status'] = (int)Request::get('news_status', 0);
        $dataSave['news_order'] = (int)Request::get('news_order', 1);
        $dataSave['news_common_page'] = (int)Request::get('news_common_page', CGlobal::status_hide);
        $dataSave['news_show_cate_id'] = (int)Request::get('news_show_cate_id', CGlobal::status_hide);
        $dataSave['news_depart_id'] = (int)Request::get('news_depart_id', CGlobal::status_hide);
        $dataSave['news_category_id'] = (int)Request::get('news_category_id', CGlobal::status_hide);
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
            $dataSave['news_image'] = ($image_primary != '')? $image_primary: $arrInputImgOther[0];
            $dataSave['news_image_other'] = serialize($arrInputImgOther);
        }

        //FunctionLib::debug($dataSave);
        if($this->valid($dataSave) && empty($this->error)) {
            $id = ($id == 0)?$id_hiden: $id;
            $dataSave['news_category_name'] = Category::getNameCategory($dataSave['news_category_id']);

            if($id > 0) {
                //cap nhat
                if(News::updateData($id, $dataSave)) {
                    return Redirect::route('admin.newsView');
                }
            } else {
                //them moi
                $dataSave['news_create'] = time();
                if(News::addData($dataSave)) {
                    return Redirect::route('admin.newsView');
                }
            }
        }
        $optionDepart = FunctionLib::getOption(array(0=>'----Chọn khoa - trung tâm (Trang chủ)----')+$this->arrDepart, isset($dataSave['news_depart_id'])? $dataSave['news_depart_id'] : CGlobal::status_hide);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['category_status'])? $dataSave['category_status'] : -1);
        $optionCommonPage = FunctionLib::getOption($this->arrCommonPage, isset($dataSave['news_common_page'])? $dataSave['news_common_page'] : CGlobal::status_hide);
        $optionTypeNew = FunctionLib::getOption($this->arrTypeNew, isset($dataSave['news_type'])? $dataSave['news_type'] : CGlobal::NEW_TYPE_TIN_TUC);
        $this->layout->content =  View::make('admin.News.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionDepart', $optionDepart)
            ->with('optionTypeNew', $optionTypeNew)
            ->with('optionCommonPage', $optionCommonPage)
            ->with('error', $this->error)
            ->with('arrStatus', $this->arrStatus);
    }

    public function deleteNews(){
        $data = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && News::deleteData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function getCategoryWithDepart(){
        $data = array('isIntOk' => 0,'msg' => 'Không lấy được thông tin danh mục');
        $news_depart_id = (int)Request::get('news_depart_id', -1);

        if ($news_depart_id > -1) {
            $category = Category::buildOptionCategoryNew($news_depart_id);
            if(!empty($category)){
                $str_option = '<option value="">---Chọn danh mục---</option>';
                foreach($category as $dis_id =>$dis_name){
                    $str_option .='<option value="'.$dis_id.'">'.$dis_name.'</option>';
                }
                $data['html_option'] = $str_option;
                $data['isIntOk'] = 1;
            }
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
    public function updateStatusNew()
    {
        $id = (int)Request::get('id', 0);
        $category_status = (int)Request::get('status', CGlobal::status_hide);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            $dataSave['news_status'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
            if(News::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }
}