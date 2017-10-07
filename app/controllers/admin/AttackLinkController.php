<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class AttackLinkController extends BaseAdminController{
	private $permission_view = 'attackLink_view';
	private $permission_full = 'attackLink_full';
	private $permission_delete = 'attackLink_delete';
	private $permission_create = 'attackLink_create';
	private $permission_edit = 'attackLink_edit';
	
	private $arrStatus = array(-1 => 'Chọn trạng thái', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
	private $arrType = array(-1 => 'Chọn loại liên kết',
		CGlobal::TYPE_LINK_COQUAN => 'Cơ quan Đảng - Nhà nước',
		CGlobal::TYPE_LINK_TRUONG => 'Các trường ĐH - CĐ',
		CGlobal::TYPE_LINK_WEBSITE => 'Các website khác');
	private $error = array();
	public function __construct(){
		parent::__construct();
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
	public function view(){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission)&& !in_array($this->permission_view,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['link_title'] = addslashes(Request::get('link_title', ''));
		$search['link_status'] = (int)Request::get('link_status', -1);

		$data = AttackLink::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getNewPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		$optionStatus = FunctionLib::getOption($this->arrStatus, $search['link_status']);
		$messages = FunctionLib::messages('messages');
		
		$this->layout->content = View::make('admin.AttackLink.list')
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('arrStatus', $this->arrStatus)
								->with('arrType', $this->arrType)
								->with('optionStatus', $optionStatus)
								->with('search', $search)
								->with('is_root', $this->is_root)
								->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
								->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
								->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
								->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
								->with('messages', $messages);
	}
	public function getItem($id=0){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}
		$data = array();
		if($id > 0) {
			$data = AttackLink::getById($id);
		}

		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['link_status'])? $data['link_status'] : CGlobal::status_show);
		$optionType = FunctionLib::getOption($this->arrType, isset($data['link_type'])? $data['link_type'] : CGlobal::TYPE_LINK_TRUONG);
		$this->layout->content = View::make('admin.AttackLink.add')
		->with('id', $id)
		->with('data', $data)
		->with('optionStatus', $optionStatus)
		->with('optionType', $optionType)
		->with('is_root', $this->is_root)
		->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
		->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
		->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
		->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
		->with('error', $this->error);
	}
	public function postItem($id=0){
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_edit,$this->permission) && !in_array($this->permission_create,$this->permission)){
			return Redirect::route('admin.dashboard',array('error'=>1));
		}

		$dataSave['link_title'] = addslashes(Request::get('link_title'));
		$dataSave['link_url'] = addslashes(Request::get('link_url'));
		$dataSave['link_status'] = (int)Request::get('link_status', CGlobal::status_show);
		$dataSave['link_order'] = (int)Request::get('link_order', 1);
		$dataSave['link_type'] = (int)Request::get('link_type', 1);

		if($this->valid($dataSave) && empty($this->error)) {
			if($id > 0) {
				//cap nhat
				if(AttackLink::updateData($id, $dataSave)) {
					return Redirect::route('admin.attackLinkView');
				}
			} else {
				//them moi
				if(AttackLink::addData($dataSave)) {
					return Redirect::route('admin.attackLinkView');
				}
			}
		}
		$optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['link_status'])? $dataSave['link_status'] : -1);
		$optionType = FunctionLib::getOption($this->arrType, isset($dataSave['link_type'])? $dataSave['link_type'] : -1);
		$this->layout->content =  View::make('admin.AttackLink.add')
			->with('id', $id)
			->with('data', $dataSave)
			->with('optionStatus', $optionStatus)
			->with('optionType', $optionType)
			->with('permission_full', in_array($this->permission_full, $this->permission) ? 1 : 0)
			->with('permission_create', in_array($this->permission_create, $this->permission) ? 1 : 0)
			->with('permission_delete', in_array($this->permission_delete, $this->permission) ? 1 : 0)
			->with('permission_edit', in_array($this->permission_edit, $this->permission) ? 1 : 0)
			->with('error', $this->error);
	}

	private function valid($data=array()) {
		if(!empty($data)) {
			if(isset($data['link_title']) && $data['link_title'] == '') {
				$this->error[] = 'Tên link liên kết chưa có.';
			}
			if(isset($data['link_url']) && $data['link_url'] == '') {
				$this->error[] = 'Bạn chưa nhập URL cho link liên kết';
			}
			if(isset($data['link_type']) && $data['link_type'] == -1) {
				$this->error[] = 'Bạn chưa chọn kiểu link liên kết';
			}
			return true;
		}
		return false;
	}

	public function deleteLink(){
		$data = array('isIntOk' => 0);
		if(!$this->is_root && !in_array($this->permission_full,$this->permission) && !in_array($this->permission_delete,$this->permission)){
			return Response::json($data);
		}
		$id = (int)Request::get('id', 0);
		if ($id > 0 && AttackLink::deleteId($id)) {
			$data['isIntOk'] = 1;
		}
		return Response::json($data);
	}
}