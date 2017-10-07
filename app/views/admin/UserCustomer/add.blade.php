<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.customerView')}}"> Danh sách Shop</a></li>
            <li class="active">@if($id > 0)Cập nhật User shop @else Tạo mới User shop @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('role'=>'form','url' =>($id > 0)? "admin/customer/postEditCustomer/$id" : 'admin/customer/getEditCustomer','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="customer_email" class="control-label">Email đăng nhập</label>
                        <input type="text" placeholder="Email đăng nhập" id="customer_email" name="customer_email" class="form-control input-sm" value="@if(isset($data['customer_email'])){{$data['customer_email']}}@endif">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="name" class="control-label">Đổi pass - nếu có</label>
                        <input type="password" id="customer_password" name="customer_password" class="form-control input-sm" value="">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Tên khách đăng tin</label>
                        <input type="text" placeholder="Tên khách" id="customer_name" name="customer_name" class="form-control input-sm" value="@if(isset($data['customer_name'])){{$data['customer_name']}}@endif">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="name" class="control-label">Lượt share</label>
                        <input type="text" placeholder="Lượt up" id="customer_number_share" name="customer_number_share" class="form-control input-sm" value="@if(isset($data['customer_number_share'])){{$data['customer_number_share']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="name" class="control-label">Số điện thoại</label>
                        <input type="text" placeholder="Số điện thoại" id="customer_phone" name="customer_phone" class="form-control input-sm" value="@if(isset($data['customer_phone'])){{$data['customer_phone']}}@endif">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Địa chỉ</label>
                        <input type="text" placeholder="Địa chỉ" id="customer_address" name="customer_address" class="form-control input-sm" value="@if(isset($data['customer_address'])){{$data['customer_address']}}@endif">
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Trạng thái</label>
                        <select name="customer_status" id="customer_status" class="form-control input-sm" onchange="Admin.changeStatusShop(this.value,{{$id}});">
                            {{$optionStatus}}
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Kiểu shop</label>
                        <select name="is_customer" id="is_customer" class="form-control input-sm" onchange="Admin.changeIsShop(this.value,{{$id}});">
                            {{$optionIsCustomer}}
                        </select>
                        <img src="{{Config::get('config.WEB_ROOT')}}assets/admin/img/ajax-loader.gif" width="20" style="display: none" id="img_loading">
                    </div>
                </div>
                <div id="block_time_vip"@if(isset($data['is_customer']) && $data['is_customer'] != CGlobal::CUSTOMER_VIP) style="display: none"@endif>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Thời gian bắt đầu</label>
                            <input type="text" class="form-control" id="time_start_vip" name="time_start_vip"  data-date-format="dd-mm-yyyy" value="@if(isset($data['time_start_vip']) && $data['time_start_vip'] > 0){{date('d-m-Y',$data['time_start_vip'])}}@endif">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name" class="control-label">Thời gian kết thúc</label>
                            <input type="text" class="form-control" id="time_end_vip" name="time_end_vip"  data-date-format="dd-mm-yyyy" value="@if(isset($data['time_end_vip']) && $data['time_end_vip'] > 0){{date('d-m-Y',$data['time_end_vip'])}}@endif">
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Tỉnh thành</label>
                        <select name="customer_province_id" id="customer_province_id" class="form-control input-sm" onchange="Admin.getDistrictInforCustomer();">
                            {{$optionProvince}}
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Quận huyện</label>
                        <select name="customer_district_id" id="customer_district_id" class="form-control input-sm">
                            {{$optionDistrict}}
                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12 text-left">
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>

<script>
    $(document).ready(function(){
        var checkin = $('#time_start_vip').datepicker({ });
        var checkout = $('#time_end_vip').datepicker({ });
    });
    /*CKEDITOR.replace(
            'shop_about',
            {
                toolbar: [
                    { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                    { name: 'colors',      items : [ 'TextColor','BGColor' ] },
                ],
            },
            {height:800}
    );*/
</script>