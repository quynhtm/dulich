<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.categoryDepart_list')}}"> Danh sách Chuyên nghành</a></li>
            <li class="active">@if($id > 0)Cập nhật Chuyên nghành @else Tạo mới Chuyên nghành @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('role'=>'form','files' => true))}}
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
                            <label for="name" class="control-label">Tên tab con<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên tab con" id="tab_sub_name" name="tab_sub_name"  class="form-control input-sm" value="@if(isset($data['tab_sub_name'])){{$data['tab_sub_name']}}@endif">
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
                                <input name="tab_sub_image" type="hidden" id="tab_sub_image" @if(isset($data['tab_sub_image']))value="{{$data['tab_sub_image']}}"@else value="" @endif>
                                <input name="tab_sub_image_old" type="hidden" id="tab_sub_image_old" @if(isset($data['tab_sub_image']))value="{{$data['tab_sub_image']}}"@else value="" @endif>
                            </div>
                            @if(isset($data['tab_sub_image']) && $data['tab_sub_image'] !='')
                                <div class="form-group">
                                    <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_TAB_SUB, $data['tab_sub_id'], $data['tab_sub_image'], CGlobal::sizeImage_100, '', true, CGlobal::type_thumb_image_banner, false)}}">
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Link url<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Link url" id="tab_sub_link" name="tab_sub_link"  class="form-control input-sm" value="@if(isset($data['tab_sub_link'])){{$data['tab_sub_link']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc tab ngành đào tạo</label>
                            <select name="tab_parent_id" id="tab_parent_id" class="form-control input-sm">
                                {{$optionTabParent}}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="tab_sub_status" id="tab_sub_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Vị trí hiển thị</label>
                            <input type="text" placeholder="Vị trí hiển thị" id="tab_sub_order" name="tab_sub_order"  class="form-control input-sm" value="@if(isset($data['tab_sub_order'])){{$data['tab_sub_order']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.tabSubView')}}"><i class="fa fa-reply"></i> Trở lại</a>
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
