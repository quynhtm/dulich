<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class CategoryController extends BaseAdminController
{
    private $permission_full = 'category_full';
    private $permission_view = 'category_view';
    private $permission_delete = 'category_delete';
    private $permission_create = 'category_create';
    private $permission_edit = 'category_edit';
    private $arrStatus = array(-1 => '----Chọn trạng thái----', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrShowHide = array(CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện thị');

    private $arrCategoryParent = array(-1 => '---Chọn danh mục cha----');
    private $arrCategoryDepart = array(-1 => '---Chọn khoa - trung tâm----');

    public function __construct()
    {
        parent::__construct();

       /* //Include style.
        FunctionLib::link_css(array(
            'lib/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/jquery.uploadfile.js',
        ));*/
        
        $this->arrCategoryParent = Category::getAllParentCategoryId();

        $userDepar = explode(',',$this->user_group_depart);
        $this->arrCategoryDepart = Department::getDepartWithUser($userDepar,$this->is_root);
    }

    public function view() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = $treeCategroy = array();
        $total = 0;

        $search['category_id'] = addslashes(Request::get('category_id',''));
        $search['category_name'] = addslashes(Request::get('category_name',''));
        $search['category_status'] = (int)Request::get('category_status',-1);
        $search['category_depart_id'] = (int)Request::get('category_depart_id',0);
        if(!$this->is_root){
            $search['string_depart_id'] = $this->user_group_depart;
        }
        
        $dataSearch = Category::searchByCondition($search, 500, $offset,$total);
        $paging = '';
        if(!empty($dataSearch)){
            if($search['category_status'] == -1 && $search['category_name'] == '' ){
                $data = Category::getTreeCategory($dataSearch);
            }else{
                $data = $dataSearch;
            }
        }

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['category_status']);
        $optionCategoryDepart = FunctionLib::getOption(array(0 =>'--- Chọn khoa-trung tâm (Trang chủ)---')+$this->arrCategoryDepart, $search['category_depart_id']);
        $this->layout->content = View::make('admin.Category.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('data', $data)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('optionCategoryDepart', $optionCategoryDepart)

            ->with('arrCategoryDepart', $this->arrCategoryDepart)
            ->with('arrCategoryParent', $this->arrCategoryParent)

            ->with('is_root', $this->is_root)//dùng common
            ->with('is_boss', $this->is_boss)//dùng common
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
        if($id > 0) {
            $data = Category::find($id);
            //FunctionLib::debug($data);
        }

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['category_status'])? $data['category_status'] : -1);
        $category_depart_id = isset($data['category_depart_id'])? $data['category_depart_id'] : 0;
        $category = Category::buildOptionCategoryNew($category_depart_id);
        //FunctionLib::debug($category);
        $optionCategoryParent = FunctionLib::getOption(array(0=>'--- Chọn danh mục cha ---')+$category, isset($data['category_parent_id'])? $data['category_parent_id'] : -1);
        $optionCategoryDepart = FunctionLib::getOption(array(0=>'--- Chọn khoa-trung tâm (Trang chủ) ---')+$this->arrCategoryDepart, $category_depart_id);
        $this->layout->content = View::make('admin.Category.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionCategoryDepart', $optionCategoryDepart)
            ->with('arrShowHide', $this->arrShowHide)
        	->with('optionCategoryParent', $optionCategoryParent);
    }

    public function postItem($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $dataSave['category_name'] = addslashes(Request::get('category_name'));
        $dataSave['category_status'] = (int)Request::get('category_status', 0);
        $dataSave['category_parent_id'] = (int)Request::get('category_parent_id', 0);
        $dataSave['category_order'] = (int)Request::get('category_order', 0);
        $dataSave['category_depart_id'] = (int)Request::get('category_depart_id', 0);
        $dataSave['category_show_top'] = (int)Request::get('category_show_top', CGlobal::status_hide);
        $dataSave['category_show_left'] = (int)Request::get('category_show_left', CGlobal::status_hide);
        $dataSave['category_show_right'] = (int)Request::get('category_show_right', CGlobal::status_hide);
        $dataSave['category_show_center'] = (int)Request::get('category_show_center', CGlobal::status_hide);
        $dataSave['category_link'] = addslashes(Request::get('category_link', ''));

        $file = Input::file('image');
        if($file){
            $filename = $file->getClientOriginalName();
            $destinationPath = Config::get('config.DIR_ROOT').'/uploads/'.CGlobal::FOLDER_CATEGORY.'/'. $id;
            $upload  = Input::file('image')->move($destinationPath, $filename);
            //xóa ảnh cũ
            if($filename != ''){
                $category_image_old = Request::get('category_image_old', '');
                if($category_image_old != '')
                {
                    //xoa anh upload
                    FunctionLib::deleteFileUpload($category_image_old,$id,CGlobal::FOLDER_CATEGORY);

                    //xóa anh thumb
                    $arrSizeThumb = CGlobal::$arrSizeImage;
                    foreach($arrSizeThumb as $k=>$size){
                        $sizeThumb = $size['w'].'x'.$size['h'];
                        FunctionLib::deleteFileThumb($category_image_old,$id,CGlobal::FOLDER_CATEGORY,$sizeThumb);
                    }
                }
            }
            $dataSave['category_image'] = $filename;
        }else{
            $dataSave['category_image'] = Request::get('category_image', '');
        }

        if($this->valid($dataSave) && empty($this->error)) {
            $category_level = Category::getLevelParentId($dataSave['category_parent_id']);
            $dataSave['category_level'] = ($category_level <=2) ? $category_level : 2;
            if($id > 0) {
                if($dataSave['category_parent_id'] == $id){
                    return Redirect::route('admin.category_list',array('category_depart_id'=>$dataSave['category_depart_id']));
                }
                //cap nhat
                $dataSave['category_date_update'] = time();
                $dataSave['category_user_id_update'] = $this->user['user_id'];
                $dataSave['category_user_name_update'] = $this->user['user_name'];
                //FunctionLib::debug($dataSave);
                if(Category::updateData($id, $dataSave)) {
                    return Redirect::route('admin.category_list',array('category_depart_id'=>$dataSave['category_depart_id']));
                }
            } else {
                //them moi
                $dataSave['category_date_creater'] = time();
                $dataSave['category_user_id_creater'] = $this->user['user_id'];
                $dataSave['category_user_name_creater'] = $this->user['user_name'];
                if(Category::addData($dataSave)) {
                    return Redirect::route('admin.category_list',array('category_depart_id'=>$dataSave['category_depart_id']));
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['category_status'])? $dataSave['category_status'] : -1);
        $optionCategoryParent = FunctionLib::getOption(array(0=>'--- Chọn danh mục cha ---')+$this->arrCategoryParent, isset($dataSave['category_parent_id'])? $dataSave['category_parent_id'] : -1);
        $optionCategoryDepart = FunctionLib::getOption(array(0=>'--- Chọn khoa-trung tâm (Trang chủ)---')+$this->arrCategoryDepart, isset($dataSave['category_depart_id'])? $dataSave['category_depart_id'] : 0);

        $this->layout->content =  View::make('admin.Category.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionCategoryDepart', $optionCategoryDepart)
            ->with('error', $this->error)
            ->with('arrShowHide', $this->arrShowHide)
        	->with('optionCategoryParent', $optionCategoryParent);
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
    public function deleteCategory()
    {
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Category::deleteData($id)) {
            $result['isIntOk'] = 1;
        }
        return Response::json($result);
    }

    //ajax
    public function updateStatusCategory()
    {
        $id = (int)Request::get('id', 0);
        $category_status = (int)Request::get('status', CGlobal::status_hide);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            $dataSave['category_status'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
            if(Category::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }

    //ajax
    public function updatePositionStatusCategory()
    {
        $id = (int)Request::get('id', 0);
        $category_status = (int)Request::get('status', CGlobal::status_hide);
        $position = (int)Request::get('position', 1);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            switch( $position ){
                case 1://top
                    $dataSave['category_show_top'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
                    break;
                case 2://left
                    $dataSave['category_show_left'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
                    break;
                case 3://right
                    $dataSave['category_show_right'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
                    break;
                case 4://center
                    $dataSave['category_show_center'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
                    break;
                default:
                    $dataSave['category_show_top'] = ($category_status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
                    break;
            }

            if(Category::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }

    public function getCategoryParentWithDepart(){
        $data = array('isIntOk' => 0,'msg' => 'Không lấy được thông tin danh mục');
        $category_depart_id = (int)Request::get('category_depart_id', -1);
        if ($category_depart_id > -1) {
            //$category = Category::getCategoryByDepartId($category_depart_id);
            $category = Category::buildOptionCategoryNew($category_depart_id);
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

}