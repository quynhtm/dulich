<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.category_list')}}"> Danh sách danh mục</a></li>
            <li class="active">@if($id > 0)Cập nhật danh mục @else Tạo mới danh mục @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST','role'=>'form','files' => true))}}
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
                            <label for="name" class="control-label">Tên danh mục<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên danh mục" id="category_name" name="category_name"  class="form-control input-sm" value="@if(isset($data['category_name'])){{$data['category_name']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc Khoa - trung tâm</label>
                            <select name="category_depart_id" id="category_depart_id" class="form-control input-sm" onchange="Admin.getCategoryParentWithDepart();">
                                {{$optionCategoryDepart}}
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Danh mục cha</label>
                            <select name="category_parent_id" id="category_parent_id" class="form-control input-sm">
                                {{$optionCategoryParent}}
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Liên kết thay thế</label>
                            <input type="text" placeholder="Liên kết thay thế" id="category_link" name="category_link"  class="form-control input-sm" value="@if(isset($data['category_link'])){{$data['category_link']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="category_status" id="category_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name" class="control-label">Thứ tự hiển thị</label>
                            <input type="text" placeholder="Thứ tự hiển thị" id="category_order" name="category_order"  class="form-control input-sm" value="@if(isset($data['category_order'])){{$data['category_order']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.category_list')}}"><i class="fa fa-reply"></i> Trở lại</a>
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>

                <div style="float: left; width: 50%">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Hiển thị menu header</label>
                            <select name="category_show_top" id="category_show_top" class="form-control input-sm">
                                @foreach ($arrShowHide as $key_top => $category_show_top)
                                    <option value="{{$key_top}}" @if(isset($data['category_show_top']) && $data['category_show_top'] == $key_top) selected @endif>{{$category_show_top}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Hiển thị menu bên trái</label>
                            <select name="category_show_left" id="category_show_left" class="form-control input-sm">
                                @foreach ($arrShowHide as $key_left => $category_show_left)
                                    <option value="{{$key_left}}" @if(isset($data['category_show_left']) && $data['category_show_left'] == $key_left) selected @endif>{{$category_show_left}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Hiển thị menu phải</label>
                            <select name="category_show_right" id="category_show_right" class="form-control input-sm">
                                @foreach ($arrShowHide as $key_right => $category_show_right)
                                    <option value="{{$key_right}}" @if(isset($data['category_show_right']) && $data['category_show_right'] == $key_right) selected @endif>{{$category_show_right}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Hiển thị nội dung giữa</label>
                            <select name="category_show_center" id="category_show_center" class="form-control input-sm">
                                @foreach ($arrShowHide as $key_center => $category_show_center)
                                    <option value="{{$key_center}}" @if(isset($data['category_show_center']) && $data['category_show_center'] == $key_center) selected @endif>{{$category_show_center}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if(isset($id) && $id > 0)
                    <div class="clearfix"></div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <i>Ảnh đại diện</i>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input name="image" type="file"/>
                            <input name="category_image" type="hidden" id="category_image" @if(isset($data['category_image']))value="{{$data['category_image']}}"@else value="" @endif>
                            <input name="category_image_old" type="hidden" id="category_image_old" @if(isset($data['category_image']))value="{{$data['category_image']}}"@else value="" @endif>
                        </div>
                        @if(isset($data['category_image']) && $data['category_image'] !='')
                            <div class="form-group">
                                <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_CATEGORY, $data['category_id'], $data['category_image'], CGlobal::sizeImage_100, '', true, CGlobal::type_thumb_image_banner, false)}}">
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /.page-content -->
</div>
