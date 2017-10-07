<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh mục tin bài</li>
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
                            <label for="category_name">Tên danh mục</label>
                            <input type="text" class="form-control input-sm" id="category_name" name="category_name" placeholder="Tên danh mục" @if(isset($search['category_name']) && $search['category_name'] != '')value="{{$search['category_name']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_content_front">Thuộc khoa - trung tâm</label>
                            <select name="category_depart_id" id="category_depart_id" class="form-control input-sm">
                                {{$optionCategoryDepart}}
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Trạng thái</label>
                            <select name="category_status" id="category_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                        
                    </div>
                    <div class="panel-footer text-right">
                        @if($is_root || $permission_full ==1 || $permission_create == 1)
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.category_edit')}}">
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
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> danh mục @endif </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="2%"class="text-center">STT</th>
                            <th width="8%"class="text-center">Ảnh</th>
                            <!--<th width="1%" class="text-center"><input type="checkbox" id="checkAll"/></th>-->
                            <th width="40%" class="td_list">Tên danh mục</th>
                            <th width="15%" class="td_list">Khoa - trung tâm</th>
                            <th width="5%" class="text-center">Thứ tự</th>

                            <th width="5%" class="text-center">Show header</th>
                            <th width="5%" class="text-center">Show trái</th>
                            <th width="5%" class="text-center">Show phải</th>
                            <th width="5%" class="text-center">Show center</th>

                            <th width="15%" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td class="text-center">
                                    @if($item['category_image'] !='')
                                    <img src="{{ ThumbImg::getImageThumb(CGlobal::FOLDER_CATEGORY, $item['category_id'], $item['category_image'], CGlobal::sizeImage_100, '', true, CGlobal::type_thumb_image_banner, false)}}" width="50" height="50">
                                    @endif
                                </td>
                                <!--<td class="text-center"><input class="check" type="checkbox" name="checkItems[]" id="sys_checkItems" value="{{$item['category_id']}}"></td>-->
                                <td>
                                   @if($is_boss)[<b>{{ $item['category_id'] }}</b>]@endif
                                       @if($item['category_parent_id']==0)
                                           <b><a target="_blank" @if($item['category_link'] != '')href="{{$item['category_link']}}" @else href="{{FunctionLib::buildLinkCategory($item['category_id'], $item['category_name'])}}" @endif >
                                       {{ $item['padding_left'].$item['category_name'] }}</a></b>
                                       @else
                                           {{$item['padding_left']}}<a target="_blank" @if($item['category_link'] != '')href="{{$item['category_link']}}" @else href="{{FunctionLib::buildLinkCategory($item['category_id'], $item['category_name'])}}" @endif >{{$item['category_name'] }}</a>
                                       @endif
                                </td>
                                <td>@if(isset($arrCategoryDepart[$item['category_depart_id']])){{$arrCategoryDepart[$item['category_depart_id']]}}@else --- @endif</td>
                                <td class="text-center">{{$item['category_order']}}</td>

                                <td class="text-center">
                                    @if($item['category_show_top'] == CGlobal::status_show)
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_top']}},1)"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_top']}},1)"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item['category_show_left'] == CGlobal::status_show)
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_left']}},2)"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_left']}},2)"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item['category_show_right'] == CGlobal::status_show)
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_right']}},3)"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_right']}},3)"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item['category_show_center'] == CGlobal::status_show)
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_center']}},4)"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="Admin.updatePositionStatusItem({{$item['category_id']}},{{$item['category_show_center']}},4)"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if($item['category_status'] == 1)
                                        <a href="javascript:void(0);" onclick="Admin.updateStatusItem({{$item['category_id']}},{{$item['category_status']}},1)"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="Admin.updateStatusItem({{$item['category_id']}},{{$item['category_status']}},1)"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['category_id']}}"></span>
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                       <a href="{{URL::route('admin.category_edit',array('id' => $item['category_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                       <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['category_id']}},10)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
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
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript" xmlns="http://www.w3.org/1999/html">
    $(document).ready(function() {
        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
    });
</script>