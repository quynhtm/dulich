<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class UserCustomerController extends BaseAdminController
{
    private $permission_view = 'user_customer_view';
    private $permission_full = 'user_customer_full';
    private $permission_delete = 'user_customer_delete';
    private $permission_create = 'user_customer_create';
    private $permission_edit = 'user_customer_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện', CGlobal::status_block => 'Khóa');
    private $arrCustomerActive = array(-1 => 'Tất cả', CGlobal::status_hide => 'Chưa kích hoạt', CGlobal::status_show => 'Đã kích hoạt');
    private $arrIsCustomer = array(-1 => '--- Chọn kiểu khách hàng ---', CGlobal::CUSTOMER_FREE => 'Khách Free', CGlobal::CUSTOMER_NOMAL => 'Khách thường', CGlobal::CUSTOMER_VIP => 'Khách Vip');
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
            'js/common.js',
            'admin/js/admin.js',
        ));
        CGlobal::$pageAdminTitle = 'QL khách đăng tin';
    }

    public function view() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        UserCustomer::updateCustomerLogout();//cap nhat shop login mà chưa logout
        CGlobal::$pageAdminTitle = "QL khách đăng tin | ".CGlobal::web_name;

        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['customer_id'] = addslashes(Request::get('customer_id',0));
        $search['customer_name'] = addslashes(Request::get('customer_name',''));
        $search['customer_email'] = addslashes(Request::get('customer_email',''));
        $search['customer_status'] = (int)Request::get('customer_status',-1);
        $search['is_customer'] = (int)Request::get('is_customer',-1);
        $search['customer_time_active'] = (int)Request::get('customer_time_active',-1);
        //$search['field_get'] = 'category_id,category_name,category_status';//cac truong can lay

        $dataSearch = UserCustomer::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['customer_status']);
        $optionIsShop = FunctionLib::getOption($this->arrIsCustomer, $search['is_customer']);
        $optionCustomerActive = FunctionLib::getOption($this->arrCustomerActive, $search['customer_time_active']);
        $this->layout->content = View::make('admin.UserCustomer.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('optionIsCustomer', $optionIsShop)
            ->with('optionCustomerActive', $optionCustomerActive)
            ->with('arrStatus', $this->arrStatus)
            ->with('arrIsCustomer', $this->arrIsCustomer)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }

    public function getEditCustomer($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        if($id > 0) {
            //$item = UserCustomer::find($id);
            $customer = UserCustomer::getByID($id);
            if($customer){
                $data['customer_name'] = $customer->customer_name;
                $data['customer_phone'] = $customer->customer_phone;
                $data['customer_address'] = $customer->customer_address;
                $data['customer_email'] = $customer->customer_email;
                $data['customer_show_email'] = $customer->customer_show_email;
                $data['customer_gender'] = $customer->customer_gender;
                $data['customer_birthday'] = $customer->customer_birthday;
                $data['customer_province_id'] = $customer->customer_province_id;
                $data['customer_district_id'] = $customer->customer_district_id;
                $data['customer_about'] = $customer->customer_about;//lượt up sản phẩm
                $data['customer_status'] = $customer->customer_status;
                $data['customer_number_share'] = $customer->customer_number_share;
                $data['is_customer'] = $customer->is_customer;
            }
        }
        //FunctionLib::debug($data);
        $optionIsCustomer = FunctionLib::getOption($this->arrIsCustomer, isset($data['is_customer'])? $data['is_customer'] : -1);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['customer_status'])? $data['customer_status'] : -1);

        $customer_province_id = isset($data['customer_province_id'])? $data['customer_province_id'] : 0;
        $province = Province::getAllProvince();
        $optionProvince = FunctionLib::getOption(array(0=>'---Chọn tỉnh thành----') + $province, $customer_province_id);
        $district = ($customer_province_id > 0)?Districts::getDistrictByProvinceId($customer_province_id): array();
        $optionDistrict = FunctionLib::getOption(array(0=>'---Chọn quận huyện----') + $district,isset($data['customer_district_id'])? $data['customer_district_id'] : 0);

        $this->layout->content = View::make('admin.UserCustomer.add')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionIsCustomer', $optionIsCustomer)
            ->with('optionProvince', $optionProvince)
            ->with('optionDistrict', $optionDistrict)
            ->with('arrIsCustomer', $this->arrIsCustomer)
            ->with('arrStatus', $this->arrStatus);
    }

    public function postEditCustomer($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $dataSave['customer_name'] = addslashes(Request::get('customer_name'));
        $dataSave['user_password'] = Request::get('user_password');
        $dataSave['customer_phone'] = Request::get('customer_phone');
        $dataSave['customer_address'] = addslashes(Request::get('customer_address'));
        $dataSave['customer_email'] = addslashes(Request::get('customer_email'));

        $dataSave['customer_province_id'] = addslashes(Request::get('customer_province_id'));
        $dataSave['customer_district_id'] = addslashes(Request::get('customer_district_id'));
        $dataSave['customer_about'] = addslashes(Request::get('customer_about'));

        $dataSave['time_start_vip'] = strtotime(Request::get('time_start_vip',''));
        $dataSave['time_end_vip'] = strtotime(Request::get('time_end_vip',''));

        $dataSave['customer_status'] = (int)Request::get('customer_status', 0);
        $dataSave['is_customer'] = (int)Request::get('is_customer', 0);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                if(trim($dataSave['user_password']) != ''){
                    $dataSave['user_password'] = User::encode_password(trim($dataSave['user_password']));
                }
                //cap nhat
                if(UserCustomer::updateData($id, $dataSave)) {
                    return Redirect::route('admin.customerView');
                }
            } else {
                //them moi
                if(UserCustomer::addData($dataSave)) {
                    return Redirect::route('admin.customerView');
                }
            }
        }
        $optionIsCustomer = FunctionLib::getOption($this->arrIsCustomer, isset($dataSave['is_customer'])? $dataSave['is_customer'] : -1);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['customer_status'])? $dataSave['customer_status'] : -1);

        $customer_province_id = isset($dataSave['customer_province_id'])? $dataSave['customer_province_id'] : 0;
        $province = Province::getAllProvince();
        $optionProvince = FunctionLib::getOption(array(0=>'---Chọn tỉnh thành----') + $province, $customer_province_id);
        $district = ($customer_province_id > 0)?Districts::getDistrictByProvinceId($customer_province_id): array();
        $optionDistrict = FunctionLib::getOption(array(0=>'---Chọn quận huyện----') + $district,isset($dataSave['customer_district_id'])? $dataSave['customer_district_id'] : 0);

        $this->layout->content =  View::make('admin.UserCustomer.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionIsCustomer', $optionIsCustomer)
            ->with('optionProvince', $optionProvince)
            ->with('optionDistrict', $optionDistrict)
            ->with('error', $this->error)
            ->with('arrStatus', $this->arrStatus);
    }

    public function loginToCustomer($shop_id=0) {
        if(!$this->is_root){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        if($shop_id > 0){
            $userShop = UserCustomer::find($shop_id);
            if($userShop){
                //xoa session cũ
                if (Session::has('user_customer')) {
                    Session::forget('user_customer');//xóa session
                }
                Session::put('user_customer', $userShop, 60*24);
                return Redirect::route('customer.ItemsList');
            }
        }
        return Redirect::route('admin.customerView');
    }

    private function valid($data=array()) {
        return true;
        if(!empty($data)) {
            if(isset($data['shop_name']) && $data['shop_name'] == '') {
                $this->error[] = 'Tên danh mục không được trống';
            }
            if(isset($data['shop_status']) && $data['shop_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái cho danh mục';
            }
            return true;
        }
        return false;
    }

    //ajax
    public function deleteCustomer(){
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }
        $shop_id = (int)Request::get('id', 0);
        $deleteItems = false;
        if ($shop_id > 0 && UserCustomer::deleteData($shop_id)) {
            //xóa các tin đăng của shop nay
            $deleteItems = true;
            $arrayItems = Items::getListItemsOfCustomerId($shop_id,array('item_id','customer_id'));
            if($arrayItems && sizeof($arrayItems) > 0){
                foreach($arrayItems as $item){
                    if(Items::deleteData($item->item_id)){
                        $deleteItems = true;
                    }
                }
            }
        }
        $result['isIntOk'] = ($deleteItems)? 1: 0;
        return Response::json($result);
    }

    //ajax
    public function setIsCustomer(){
        $customer_id = (int)Request::get('customer_id', 0);
        $is_customer = (int)Request::get('is_customer', CGlobal::CUSTOMER_FREE);
        $result = array('isIntOk' => 0);
        $updateProduct = false;
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)){
            return Response::json($result);
        }
        if ($customer_id > 0) {
            $dataSave['is_customer'] = $is_customer;
            if($is_customer == CGlobal::CUSTOMER_VIP){
                $dataSave['time_start_vip'] = time();
                $dataSave['time_end_vip'] =  mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);
            }else{
                $dataSave['time_start_vip'] = 0;
                $dataSave['time_end_vip'] = 0;
            }
            if(UserCustomer::updateData($customer_id, $dataSave)) {
                $updateProduct = true;
                //cap nhật sản phẩm theo is_shop
                $arrayItems = Items::getListItemsOfCustomerId($customer_id,array('item_id','customer_id'));
                if($arrayItems && sizeof($arrayItems) > 0){
                    $inforCustomer = UserCustomer::getByID($customer_id);
                    if($inforCustomer){
                        $arryUpdatePro = array(
                            'customer_id'=>$inforCustomer->customer_id,
                            'item_province_id'=>$inforCustomer->customer_province_id,
                            'item_district_id'=>$inforCustomer->customer_district_id,
                            'is_customer'=>$is_customer,
                            'customer_name'=>$inforCustomer->customer_name);
                        foreach($arrayItems as $product){
                            if(Items::updateData($product->item_id,$arryUpdatePro)){
                                $updateProduct = true;
                            }
                        }
                    }
                }
                $result['isIntOk'] = ($updateProduct)? 1: 0;
            }
        }
        return Response::json($result);
    }
    //ajax
    public function updateStatusCustomer(){
        $customer_id = (int)Request::get('customer_id', 0);
        $customer_status = (int)Request::get('customer_status', CGlobal::status_show);
        $result = array('isIntOk' => 0);
        $updateProduct = false;
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)){
            return Response::json($result);
        }
        if ($customer_id > 0) {
            $dataSave['customer_status'] = $customer_status;
            if(UserCustomer::updateData($customer_id, $dataSave)) {
                $updateProduct = true;
                //cap nhật sản phẩm theo trang thái của shop
                $arrayItems = Items::getListItemsOfCustomerId($customer_id,array('item_id','customer_id'));
                if($arrayItems && sizeof($arrayItems) > 0){
                    $inforCustomer = UserCustomer::getByID($customer_id);
                    if($inforCustomer){
                        $arryUpdatePro = array(
                            'customer_id'=>$inforCustomer->customer_id,
                            'item_province_id'=>$inforCustomer->customer_province_id,
                            'item_district_id'=>$inforCustomer->customer_district_id,
                            'is_customer'=>$inforCustomer->is_customer,
                            'item_status'=>($customer_status == CGlobal::status_show)? $customer_status: CGlobal::status_hide,
                            'item_block'=>($customer_status == CGlobal::status_block) ? 0 : 1,
                            'customer_name'=>$inforCustomer->customer_name);
                        foreach($arrayItems as $product){
                            if(Items::updateData($product->item_id,$arryUpdatePro)){
                                $updateProduct = true;
                            }
                        }
                    }
                }
                $result['isIntOk'] = ($updateProduct)? 1: 0;
            }
        }
        return Response::json($result);
    }

}