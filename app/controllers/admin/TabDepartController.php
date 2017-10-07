<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 */
class TabDepartController extends BaseAdminController
{
    private $permission_full = 'tab_full';
    private $permission_view = 'tab_view';
    private $permission_delete = 'tab_delete';
    private $permission_create = 'tab_create';
    private $permission_edit = 'tab_edit';
    private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrTabParent = array();
    private $error = array();

    public function __construct()
    {
        parent::__construct();
        $this->arrTabParent = Tab::getDepart();
    }

    public function viewTab() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = $treeCategroy = array();
        $total = 0;

        $search['tab_name'] = addslashes(Request::get('tab_name',''));
        $search['tab_status'] = (int)Request::get('tab_status',-1);
        $dataSearch = Tab::searchByCondition($search, $limit, $offset,$total);
        $paging = '';
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['tab_status']);
        $this->layout->content = View::make('admin.TabDepart.viewTab')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }
    public function getTab($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        if($id > 0) {
            $data = Tab::find($id);
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['tab_status'])? $data['tab_status'] : CGlobal::status_show);
        $this->layout->content = View::make('admin.TabDepart.addTab')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus);
    }
    public function postTab($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $dataSave['tab_name'] = addslashes(Request::get('tab_name'));
        $dataSave['tab_link'] = addslashes(Request::get('tab_link'));
        $dataSave['tab_status'] = (int)Request::get('tab_status', CGlobal::status_show);
        $dataSave['tab_order'] = (int)Request::get('tab_order', 1);

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                //cap nhat
                if(Tab::updateData($id, $dataSave)) {
                    return Redirect::route('admin.tabView');
                }
            } else {
                //them moi
                if(Tab::addData($dataSave)) {
                    return Redirect::route('admin.tabView');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['tab_status'])? $dataSave['tab_status'] : -1);
        $this->layout->content =  View::make('admin.TabDepart.addTab')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('error', $this->error);
    }
    public function updateStatusTab()
    {
        $id = (int)Request::get('id', 0);
        $status = (int)Request::get('status', CGlobal::status_hide);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            $dataSave['tab_status'] = ($status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
            if(Tab::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }

    public function viewTabSub() {
        //Check phan quyen.
        if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = $treeCategroy = array();
        $total = 0;

        $search['tab_sub_name'] = addslashes(Request::get('tab_sub_name',''));
        $search['tab_sub_status'] = (int)Request::get('tab_sub_status',-1);
        $dataSearch = TabSub::searchByCondition($search, $limit, $offset,$total);
        $paging = '';
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['tab_sub_status']);
        $this->layout->content = View::make('admin.TabDepart.viewTabSub')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('arrTabParent', $this->arrTabParent)
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)

            ->with('is_root', $this->is_root)//dùng common
            ->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)//dùng common
            ->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0);//dùng common
    }
    public function getTabSub($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }
        $data = array();
        if($id > 0) {
            $data = TabSub::find($id);
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['tab_sub_status'])? $data['tab_sub_status'] : CGlobal::status_show);
        $optionTabParent = FunctionLib::getOption(array(0=>'--Chọn tab cha--')+$this->arrTabParent, isset($data['tab_parent_id'])? $data['tab_parent_id'] : 0);
        $this->layout->content = View::make('admin.TabDepart.addTabSub')
            ->with('id', $id)
            ->with('data', $data)
            ->with('optionTabParent', $optionTabParent)
            ->with('optionStatus', $optionStatus);
    }
    public function postTabSub($id=0) {
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
            return Redirect::route('admin.dashboard',array('error'=>1));
        }

        $dataSave['tab_sub_name'] = addslashes(Request::get('tab_sub_name'));
        $dataSave['tab_sub_link'] = addslashes(Request::get('tab_sub_link'));
        $dataSave['tab_sub_status'] = (int)Request::get('tab_sub_status', CGlobal::status_show);
        $dataSave['tab_sub_order'] = (int)Request::get('tab_sub_order', 1);
        $dataSave['tab_parent_id'] = (int)Request::get('tab_parent_id', 0);

        $file = Input::file('image');
        if($file){
            $filename = $file->getClientOriginalName();
            $destinationPath = Config::get('config.DIR_ROOT').'/uploads/'.CGlobal::FOLDER_TAB_SUB.'/'. $id;
            $upload  = Input::file('image')->move($destinationPath, $filename);
            //xóa ảnh cũ
            if($filename != ''){
                $tab_sub_image_old = Request::get('tab_sub_image_old', '');
                if($tab_sub_image_old != '')
                {
                    //xoa anh upload
                    FunctionLib::deleteFileUpload($tab_sub_image_old,$id,CGlobal::FOLDER_TAB_SUB);

                    //xóa anh thumb
                    $arrSizeThumb = CGlobal::$arrSizeImage;
                    foreach($arrSizeThumb as $k=>$size){
                        $sizeThumb = $size['w'].'x'.$size['h'];
                        FunctionLib::deleteFileThumb($tab_sub_image_old,$id,CGlobal::FOLDER_TAB_SUB,$sizeThumb);
                    }
                }
            }
            $dataSave['tab_sub_image'] = $filename;
        }else{
            $dataSave['tab_sub_image'] = Request::get('tab_sub_image', '');
        }

        if($this->valid($dataSave) && empty($this->error)) {
            if($id > 0) {
                //cap nhat
                if(TabSub::updateData($id, $dataSave)) {
                    return Redirect::route('admin.tabSubView');
                }
            } else {
                //them moi
                if(TabSub::addData($dataSave)) {
                    return Redirect::route('admin.tabSubView');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['tab_sub_status'])? $dataSave['tab_sub_status'] : -1);
        $optionTabParent = FunctionLib::getOption(array(0=>'Tab dưới')+$this->arrTabParent, isset($dataSave['tab_parent_id'])? $dataSave['tab_parent_id'] : 0);
        $this->layout->content =  View::make('admin.TabDepart.addTabSub')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('optionStatus', $optionStatus)
            ->with('optionTabParent', $optionTabParent)
            ->with('error', $this->error);
    }
    public function updateStatusTabSub()
    {
        $id = (int)Request::get('id', 0);
        $status = (int)Request::get('status', CGlobal::status_hide);
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }

        if ($id > 0) {
            $dataSave['tab_sub_status'] = ($status == CGlobal::status_hide)? CGlobal::status_show : CGlobal::status_hide;
            if(TabSub::updateData($id, $dataSave)) {
                $result['isIntOk'] = 1;
            }
        }
        return Response::json($result);
    }

    //Common
    private function valid($data=array()) {
        if(!empty($data)) {
            if(isset($data['category_depart_name']) && $data['category_depart_name'] == '') {
                $this->error[] = 'Tên chuyên nghành không được bỏ trống';
            }
            if(isset($data['category_depart_status']) && $data['category_depart_status'] == -1) {
                $this->error[] = 'Bạn chưa chọn trạng thái';
            }
            if(isset($data['department_id']) && $data['department_id'] < 0) {
                $this->error[] = 'Bạn chưa chọn thuộc Khoa - Trung tâm nào';
            }
            return true;
        }
        return false;
    }

    //ajax
    public function deleteTabSub()
    {
        $result = array('isIntOk' => 0);
        if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
            return Response::json($result);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && CategoryDepart::deleteData($id)) {
            $result['isIntOk'] = 1;
        }
        return Response::json($result);
    }



}