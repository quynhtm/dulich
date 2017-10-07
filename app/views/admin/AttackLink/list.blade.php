<div class="main-content-inner">
	<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="ace-icon fa fa-home home-icon"></i>
				<a href="{{URL::route('admin.dashboard')}}">Home</a>
			</li>
			<li class="active">Quản lý link liên kết</li>
		</ul><!-- /.breadcrumb -->
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->
				<div class="panel panel-info">
					{{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
					<div class="panel-body">
						<div class="form-group col-lg-3">
							<label for="province_id">Tên link liên kết</label>
							<input type="text" class="form-control input-sm" id="link_title" name="link_title" placeholder="" @if(isset($search['link_title']) && $search['link_title'] != '')value="{{$search['link_title']}}"@endif>
						</div>

						<div class="form-group col-lg-3">
							<label for="category_status">Trạng thái</label>
							<select name="link_status" id="link_status" class="form-control input-sm">
								{{$optionStatus}}
							</select>
						</div>
					</div>
					<div class="panel-footer text-right">
						@if($is_root || $permission_full ==1 || $permission_create == 1)
							<span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.editLink')}}">
								<i class="ace-icon fa fa-plus-circle"></i>
								Thêm mới
							</a>
                        </span>
						@endif
						<span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
					</div>
					{{ Form::close() }}
				</div>
				@if(sizeof($data) > 0)
					<div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </div>
					<br>
					<table class="table table-bordered table-hover">
						<thead>
						<tr>
							<th width="5%" class="text-center">STT</th>
							<!--<th width="1%" class="text-center"><input id="checkAll" type="checkbox"></th>-->
							<th width="20%">Tiêu đề link</th>
							<th width="40%">link url</th>
							<th width="15%">Thuộc kiểu liên kết</th>
							<th width="5%" class="text-center">Thứ tự</th>
							<th width="15%" class="text-center">Action</th>
						</tr>
						</thead>
						<tbody>
						@foreach($data as $k=>$item)
							<tr>
								<td class="text-center">{{$k+1}}</td>
								<!--<td class="text-center"><input class="checkItem" name="checkItem[]" value="{{$item['link_id']}}" type="checkbox"></td>-->
								<td>{{$item['link_title']}}</td>
								<td>{{$item['link_url']}}</td>
								<td>@if(isset($arrType[$item['link_type']]) && $item['link_type'] > 0){{$arrType[$item['link_type']]}}@endif</td>
								<td class="text-center">{{$item['link_order']}}</td>

								<td class="text-center">
									@if($item['link_status'] == CGlobal::status_show)
										<i class="fa fa-check fa-admin fa-2x green"></i>
									@else
										<i class="fa fa-remove fa-admin fa-2x red"></i>
									@endif
									&nbsp;&nbsp;&nbsp;
									<a href="{{URL::route('admin.editLink',array('id' => $item['link_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
									@if($is_root || $permission_full ==1 || $permission_delete == 1)
										&nbsp;&nbsp;&nbsp;
										<a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['link_id']}},20)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
									@endif
									<span class="img_loading" id="img_loading_{{$item['link_id']}}"></span>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
					<div class="text-right">
						{{$paging}}
					</div>
				@else
					<div class="alert">
						Không có dữ liệu
					</div>
					@endif
			</div>
		</div>
	</div><!-- /.page-content -->
</div>