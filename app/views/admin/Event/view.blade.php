<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Quản lý sự kiện</li>
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
                            <label for="news_title">Tên sự kiện</label>
                            <input type="text" class="form-control input-sm" id="event_title" name="event_title" placeholder="Tiêu đề" @if(isset($search['event_title']) && $search['event_title'] != '')value="{{$search['event_title']}}"@endif>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="category_status">Trạng thái</label>
                            <select name="event_status" id="event_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        @if($is_root || $permission_full ==1 || $permission_create == 1)
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.eventEdit')}}">
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
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="2%" class="text-center">TT</th>
                            <th width="8%" class="text-center">Ảnh</th>
                            <th width="43%">Tên sự kiện</th>
                            <th width="20%">Thuộc khoa - trung tâm</th>
                            <th width="8%" class="text-center">Ngày chạy</th>
                            <th width="8%" class="text-center">Trạng thái</th>
                            <th width="10%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td class="text-center">
                                   @if($item->event_image != '')
                                    <img src="{{ThumbImg::getImageThumb(CGlobal::FOLDER_EVENT, $item->event_id, $item->event_image, CGlobal::sizeImage_100,  '', true, CGlobal::type_thumb_image_banner, false)}}">
                                    @endif
                                </td>
                                <td>
                                    [<b>{{ $item['event_id'] }}</b>]<a href="{{FunctionLib::buildLinkDetailEvent($item->event_title, $item->event_id)}}" target="_blank">{{ $item['event_title'] }}</a>
                                </td>
                                <td>@if(isset($arrDepart[$item['event_depart_id']])){{ $arrDepart[$item['event_depart_id']] }}@else --- @endif</td>
                                <td class="text-center">
                                    @if($item->event_time_start > 0)<i class="green">{{date('d-m-Y',$item->event_time_start)}}</i> <br/>@endif
                                    @if($item->event_time_end > 0)<i class="red">{{date('d-m-Y',$item->event_time_end)}}</i>@endif
                                </td>
                                <td class="text-center">
                                    @if($item['event_status'] == 1)
                                        <a href="javascript:void(0);" onclick="Admin.updateStatusItem({{$item['event_id']}},{{$item['event_status']}},6)"title="Hiện"><i class="fa fa-check fa-2x"></i></a>
                                    @else
                                        <a href="javascript:void(0);" onclick="Admin.updateStatusItem({{$item['event_id']}},{{$item['event_status']}},6)"style="color: red" title="Ẩn"><i class="fa fa-close fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['event_id']}}"></span>
                                </td>

                                <td class="text-center">
                                    @if($is_root || $permission_full ==1|| $permission_edit ==1  )
                                        <a href="{{URL::route('admin.eventEdit',array('id' => $item['event_id']))}}" title="Sửa item"><i class="fa fa-edit fa-2x"></i></a>
                                    @endif
                                    @if($is_root || $permission_full ==1 || $permission_delete == 1)
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="javascript:void(0);" onclick="Admin.deleteItem({{$item['event_id']}},16)" title="Xóa Item"><i class="fa fa-trash fa-2x"></i></a>
                                    @endif
                                    <span class="img_loading" id="img_loading_{{$item['event_id']}}"></span>
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