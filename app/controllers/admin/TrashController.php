<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class TrashController extends BaseAdminController{
	private $error = '';
	public function __construct(){
		parent::__construct();
	}
	public function listView(){
		
		$Meta = array('title'=>'Trash',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		//Config Page
		$pageNo = (int) Request::get('page', 1);
		$pageScroll = CGlobal::num_scroll_page;
		$limit = CGlobal::num_record_per_page;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;
		
		$search['trash_title'] = addslashes(Request::get('trash_title', ''));
		$search['field_get'] = 'trash_id,trash_obj_id,trash_title,trash_class,trash_folder,trash_created';
		
		$dataSearch = Trash::searchByCondition($search, $limit, $offset, $total);
		$paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';
		
		if(!empty($dataSearch)){
			foreach($dataSearch as $k => $v){
				$data[] = array('trash_id'=>$v->trash_id,
								'trash_obj_id'=>$v->trash_obj_id,
								'trash_title'=>$v->trash_title,
								'trash_class'=>$v->trash_class,
								'trash_folder'=>$v->trash_folder,
								'trash_created'=>$v->trash_created,
								
				);
			}	
		}
		
		$messages = Utility::messages('messages');
		
		$this->layout->content = View::make('admin.trash.list')
								->with('data', $data)
								->with('total', $total)
								->with('paging', $paging)
								->with('search', $search)
								->with('messages', $messages);
	}
	public function getItem($id=0){
		$this->header();
		$Meta = array('title'=>'Trash',);
		foreach($Meta as $key=>$val){
			$this->layout->$key = $val;
		}
		$data = array();
		$arrField = array();
		if($id > 0) {
			$data = Trash::getById($id);
			$class = $data->trash_class;
			$ObjClass = new $class();
			$arrField = $ObjClass->getFillable();
		}
	
		$this->layout->content = View::make('admin.trash.add')
								->with('id', $id)
								->with('data', $data)
								->with('arrField', $arrField)
								->with('error', $this->error);
	}
	
	public function delete(){
		$listId = Request::get('checkItem', array());
		$token = Request::get('_token', '');
		if(Session::token() === $token){
			if(!empty($listId) && is_array($listId)){
				foreach($listId as $id){
					Trash::deleteId($id);
				}
				Utility::messages('messages', 'Xóa thành công!', 'success');
			}
		}
		return Redirect::route('admin.trash');
	}
	public function restore(){
		$listId = Request::get('checkItem', array());
		$token = Request::get('_token', '');
		if(Session::token() === $token){
			if(!empty($listId) && is_array($listId)){
				foreach($listId as $id){
					Trash::restoreItem($id);
					Trash::deleteId($id);
				}
				Utility::messages('messages', 'Khôi phục thành công!', 'success');
			}
		}
		return Redirect::route('admin.trash');
	}
}