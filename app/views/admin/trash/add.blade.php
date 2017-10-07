<div class="inner-box">
	<div class="page-title-box">
		<h5 class="padding10">Thùng rác: @if($id!= 0)Xem @endif</h5>
		<span class="menu_tools">
			<a href="javascript:void(0)" title="Khôi phục" id="restoreMoreItem" class="fa fa-reply fa-admin green"></a>
			<a href="javascript:void(0)" title="Xóa item" id="deleteMoreItem" class="fa fa-trash fa-admin red"></a>
	    </span>
	</div>
	<div class="page-content-box trash">
		@if($error != '')
		<div class="alert-admin alert alert-danger">{{ $error }}</div>
		@endif
		{{Form::open(array('method' => 'POST', 'id'=>'formListItem', 'class'=>'formListItem', 'name'=>'txtForm', 'url'=>'admin/trash/delete'))}}
		<input class="checkItem trash" name="checkItem[]" value="{{$id}}" type="checkbox">
		<div class="control-group">
			<label class="control-label">Lớp:</label>
			<div class="controls">
				@if(isset($data['trash_class'])){{$data['trash_class']}}@endif
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label">Thư mục</label>
			<div class="controls">
				@if(isset($data['trash_folder'])){{$data['trash_folder']}}@endif
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label">Nội dung</label>
			<div class="controls">
				<?php
					$trash_content = array();
					if(isset($data['trash_content'])){
						$trash_content = unserialize($data['trash_content']);
						foreach($arrField as $field){
							if(isset($trash_content[$field])){
								echo '<div class="line"><b>'.$field.':</b> '.$trash_content[$field].'</div>';
							}
						}
					}
				?>
				
			</div>
		</div>
		<div class="form-actions">
			<button type="reset" class="btn">Bỏ qua</button>
		</div>
		{{Form::close()}} 
	</div>
</div>