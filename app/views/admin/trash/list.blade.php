<div class="search-box">
	<div class="wrapp-search-box">
		<div class="search-box-title">Thông tin tìm kiếm</div>
		{{Form::open(array('method' => 'GET', 'id'=>'frmSearch', 'class'=>'frmSearch', 'name'=>'frmSearch'))}}
			<div class="row">
				<div class="col-lg-3">
					<label class="control-label">Từ khóa</label>
					<div>
						<input type="text" class="form-control input-sm" name="trash_title" @if(isset($search['trash_title']) && $search['trash_title'] !='')value="{{$search['trash_title']}}"@endif>
					</div>
				</div>
				<div class="col-lg-3">
					<label class="control-label">&nbsp;</label>
					<div><button class="btn btn-primary" name="submit" value="s">Tìm kiếm</button></div>
				</div>
			</div>
		{{Form::close()}}
	</div>
</div>
<div class="inner-box">
	<div class="page-title-box">
		<h5 class="padding10">Quản lý thùng rác</h5>
		<span class="menu_tools">
			<a href="javascript:void(0)" title="Khôi phục" id="restoreMoreItem" class="fa fa-reply fa-admin green"></a>
			<a href="javascript:void(0)" title="Xóa item" id="deleteMoreItem" class="fa fa-trash fa-admin red"></a>
	    </span>
	</div>
	<div class="page-content-box">
		@if($messages != '')
			{{ $messages }}
		@endif
		@if($total>0)
		<div class="show-bottom-info">
			<div class="total-rows">Tổng số: {{$total}}</div>
			<div class="list-item-page">
				<div class="showListPage">{{$paging}}</div>
			</div>
		</div>
		@endif
		{{Form::open(array('method' => 'POST', 'id'=>'formListItem', 'class'=>'formListItem', 'name'=>'txtForm', 'url'=>'admin/trash/delete'))}}
			<div class="showListItem">
				<table width="100%" cellspacing="1" cellpadding="5" border="1">
					<thead>
						<tr>
							<th width="2%">STT</th>
							<th width="1%"><input id="checkAll" type="checkbox"></th>
							<th width="20%">Tiêu đề</th>
							<th width="5%">ID</th>
							<th width="5%">Lớp</th>
							<th width="5%">Thư mục</th>
							<th width="5%">Ngày xóa</th>
							<th width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $k=>$item)
						<tr>
							<td>{{$k+1}}</td>
							<td><input class="checkItem" name="checkItem[]" value="{{$item['trash_id']}}" type="checkbox"></td>
							<td>{{$item['trash_title']}}</td>
							<td>{{$item['trash_obj_id']}}</td>
							<td>{{$item['trash_class']}}</td>
							<td>{{$item['trash_folder']}}</td>
							<td>{{date('d/m/Y', $item['trash_created'])}}</td>
							<td>
								<a href="{{Config::get('config.BASE_URL')}}admin/trash/edit/{{$item['trash_id']}}" title="Cập nhật">
									<i class="fa fa-edit fa-admin"></i>
								</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		{{Form::close()}}
		@if($total>0)
		<div class="show-bottom-info">
			<div class="total-rows">Tổng số: {{$total}}</div>
			<div class="list-item-page">
				<div class="showListPage">{{$paging}}</div>
			</div>
		</div>
		@endif
	</div>
</div>