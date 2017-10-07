<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.department_list')}}"> Danh sách Khoa - Trung tâm</a></li>
            <li class="active">@if($id > 0)Cập nhật Khoa - Trung tâm @else Tạo mới Khoa - Trung tâm @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('role'=>'form','url' =>($id > 0)? "admin/department/postDepartment/$id" : 'admin/department/postDepartment','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif

                <div style="float: left; width: 50%">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên Khoa - Trung tâm<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên khoa - trung tâm" id="department_name" name="department_name"  class="form-control input-sm" value="@if(isset($data['department_name'])){{$data['department_name']}}@endif">
                        </div>
                    </div>
                    @if(isset($id) && $id > 0)
                        <div class="clearfix"></div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <i>Ảnh Logo Depart</i>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <input name="image" type="file"/>
                                <input name="department_logo" type="hidden" id="department_logo" @if(isset($data['department_logo']))value="{{$data['department_logo']}}"@else value="" @endif>
                                <input name="department_logo_old" type="hidden" id="department_logo_old" @if(isset($data['department_logo']))value="{{$data['department_logo']}}"@else value="" @endif>
                            </div>
                            @if(isset($data['department_logo']) && $data['department_logo'] !='')
                                <div class="form-group">
                                    <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_DEPART_LOGO, $data['department_id'], $data['department_logo'], CGlobal::sizeImage_100, '', true, CGlobal::type_thumb_image_banner, false)}}">
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($id > 0)
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên rút gọn</label>
                            <input type="text" disabled id="department_alias" name="department_alias"  class="form-control input-sm" value="@if(isset($data['department_alias'])){{$data['department_alias']}}@endif">
                        </div>
                    </div>
                    @endif

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Kiểu</label>
                            <select name="department_type" id="department_type" class="form-control input-sm">
                                {{$optionTypeDepart}}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Layous hiển thị</label>
                            <select name="department_layouts" id="department_layouts" class="form-control input-sm">
                                {{$optionLayoutsDepart}}
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Liên kết thay thế</label>
                            <input type="text" placeholder="Liên kết thay thế" id="department_link" name="department_link"  class="form-control input-sm" value="@if(isset($data['department_link'])){{stripslashes(trim($data['department_link']))}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="department_status" id="department_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Vị trí hiển thị</label>
                            <input type="text" placeholder="Vị trí hiển thị" id="department_order" name="department_order"  class="form-control input-sm" value="@if(isset($data['department_order'])){{$data['department_order']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.department_list')}}"><i class="fa fa-reply"></i> Trở lại</a>
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
