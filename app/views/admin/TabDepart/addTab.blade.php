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
                            <label for="name" class="control-label">Tên tab<span class="red"> (*) </span></label>
                            <input type="text" placeholder="Tên tab" id="tab_name" name="tab_name"  class="form-control input-sm" value="@if(isset($data['tab_name'])){{$data['tab_name']}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên liên kết</label>
                            <input type="text" placeholder="Tab liên kết" id="tab_link" name="tab_link"  class="form-control input-sm" value="@if(isset($data['tab_link'])){{$data['tab_link']}}@endif">
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <select name="tab_status" id="tab_status" class="form-control input-sm">
                                {{$optionStatus}}
                            </select>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <label for="name" class="control-label">Vị trí hiển thị</label>
                            <input type="text" placeholder="Vị trí hiển thị" id="tab_order" name="tab_order"  class="form-control input-sm" value="@if(isset($data['tab_order'])){{$data['tab_order']}}@endif">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12 text-left">
                        <a class="btn btn-warning" href="{{URL::route('admin.tabView')}}"><i class="fa fa-reply"></i> Trở lại</a>
                        <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                    </div>
                    <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
