<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.eventView')}}"> Danh sách sự kiện</a></li>
            <li class="active">@if($id > 0)Cập nhật sự kiện @else Tạo mới sự kiện @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content marginTop30">
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
                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Tên sự kiện<span class="red"> (*) </span></label>
                        <div class="form-group">
                            <input type="text" placeholder="Tên sự kiện" id="event_title" name="event_title" class="form-control input-sm" value="@if(isset($data['event_title'])){{$data['event_title']}}@endif">
                        </div>
                    </div>
                </div>

                <div style="float: left;width: 30%">
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name" class="control-label">Thuộc khoa - trung tâm<span class="red"> (*) </span></label>
                            <div class="form-group">
                                <select class="form-control input-sm" name="event_depart_id"id="event_depart_id">
                                    <?php echo $optionDepart;?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Trạng thái</label>
                            <div class="form-group">
                                <select name="event_status" id="event_status" class="form-control input-sm">
                                    {{$optionStatus}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Kiểu tin</label>
                            <div class="form-group">
                                <select name="event_type" id="event_type" class="form-control input-sm">
                                    {{$optionTypeNew}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Ngày bắt đầu</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="event_time_start" name="event_time_start"  data-date-format="dd-mm-yyyy" value="@if(isset($data['event_time_start']) && $data['event_time_start'] > 0){{date('d-m-Y',$data['event_time_start'])}}@endif">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Ngày kết thúc</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="event_time_end" name="event_time_end"  data-date-format="dd-mm-yyyy" value="@if(isset($data['event_time_end']) && $data['event_time_end'] > 0){{date('d-m-Y',$data['event_time_end'])}}@endif">
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name" class="control-label">Thứ tự hiển thị</label>
                            <input type="text" id="event_order" name="event_order"  class="form-control input-sm" value="@if(isset($data['event_order'])){{$data['event_order']}}@endif">
                        </div>
                    </div>
                </div>

                <div style="float: left;width: 70%">
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <a href="javascript:;"class="btn btn-primary" onclick="Admin.uploadMultipleImages(6);">Upload ảnh</a>
                                        <input name="image_primary" type="hidden" id="image_primary" value="@if(isset($data['event_image'])){{$data['event_image']}}@endif">
                                        <input name="news_image_hover" type="hidden" id="image_primary_hover" value="@if(isset($data['news_image_hover'])){{$data['news_image_hover']}}@endif">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12">
                                    <!--hien thi anh-->
                                    <ul id="sys_drag_sort" class="ul_drag_sort">
                                        @if(isset($arrViewImgOther))
                                            @foreach ($arrViewImgOther as $key => $imgNew)
                                                <li id="sys_div_img_other_{{$key}}" style="margin: 1px!important;">
                                                    <div class='block_img_upload'>
                                                        <img src="{{$imgNew['src_img_other']}}" height='100' width='100'>
                                                        <input type="hidden" id="img_other_{{$key}}" name="img_other[]" value="{{$imgNew['img_other']}}" class="sys_img_other">
                                                        <div class='clear'></div>
                                                        <input type="radio" id="checked_image_{{$key}}" name="checked_image" value="{{$key}}" @if(isset($imageOrigin) && $imageOrigin == $imgNew['img_other'] ) checked="checked" @endif onclick="Admin.checkedImage('{{$imgNew['img_other']}}','{{$key}}');">
                                                        <label for="checked_image_{{$key}}" style='font-weight:normal'>Ảnh đại diện</label>
                                                        <div class="clearfix"></div>
                                                        <a href="javascript:void(0);" onclick="Admin.removeImage({{$key}},{{$id}},'{{$imgNew['img_other']}}',6);">Xóa ảnh</a>
                                                        <span style="display: none"><b>{{$key}}</b></span>
                                                    </div>
                                                </li>
                                                @if(isset($imageOrigin) && $imageOrigin == $imgNew['img_other'] )
                                                    <input type="hidden" id="news_images_key_upload" name="news_images_key_upload" value="{{$key}}">
                                                @endif
                                            @endforeach
                                        @else
                                            <input type="hidden" id="news_images_key_upload" name="news_images_key_upload" value="-1">
                                        @endif
                                    </ul>

                                    <input name="list1SortOrder" id ='list1SortOrder' type="hidden" />
                                    <script type="text/javascript">
                                        $("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
                                        function saveOrder() {
                                            var data = $("#sys_drag_sort li div span").map(function() { return $(this).children().html(); }).get();
                                            $("input[name=list1SortOrder]").val(data.join(","));
                                        };
                                    </script>
                                    <!--ket thuc hien thi anh-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Mô tả ngắn</label>
                        <textarea class="form-control input-sm" rows="8" name="event_desc_sort">@if(isset($data['event_desc_sort'])){{$data['event_desc_sort']}}@endif</textarea>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name" class="control-label">Nội dung chi tiết</label>
                        <div class="form-group">
                            <div class="controls"><button type="button" onclick="Admin.insertImageContent(6)" class="btn btn-primary">Chèn ảnh vào nội dung</button></div>
                            <textarea class="form-control input-sm"  name="event_content">@if(isset($data['event_content'])){{$data['event_content']}}@endif</textarea>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-10 text-left">
                    <a class="btn btn-warning" href="{{URL::route('admin.eventView')}}"><i class="fa fa-reply"></i> Trở lại</a>
                    <button  class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
                {{ Form::close() }}
                <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>


<!--Popup upload ảnh-->
<div class="modal fade" id="sys_PopupUploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Upload ảnh</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                <div class="form_group">
                    <div id="sys_mulitplefileuploader" class="btn btn-primary">Upload ảnh</div>
                    <div id="status"></div>

                    <div class="clearfix"></div>
                    <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                        <div id="div_image"></div>
                    </div>
                </div>
               </form>
            </div>
        </div>
    </div>
</div>
<!--Popup upload ảnh-->
<!--Popup anh khac de chen vao noi dung bai viet-->
<div class="modal fade" id="sys_PopupImgOtherInsertContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Click ảnh để chèn vào nội dung</h4>
            </div>
            <div class="modal-body">
                <form name="uploadImage" method="post" action="#" enctype="multipart/form-data">
                    <div class="form_group">
                        <div class="clearfix"></div>
                        <div class="clearfix" style='margin: 5px 10px; width:100%;'>
                            <div id="div_image_insert_content" class="float_left"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- chen anh vào noi dung-->
<script>
    $(document).ready(function(){
        var checkin = $('#event_time_start').datepicker({ });
        var checkout = $('#event_time_end').datepicker({ });
    });
    CKEDITOR.replace('event_content', {height:800});
    /*CKEDITOR.replace(
            'news_content',
            {
                toolbar: [
                    { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
                    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                    { name: 'colors',      items : [ 'TextColor','BGColor' ] },
                ],
            },
            {height:600}
    );*/
</script>

<script type="text/javascript">
    //kéo thả ảnh
    jQuery("#sys_drag_sort").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder });
    function saveOrder() {
        var data = jQuery("#sys_drag_sort li div span").map(function() { return jQuery(this).children().html(); }).get();
        jQuery("input[name=list1SortOrder]").val(data.join(","));
    };
    function insertImgContent(src, name_news){
        CKEDITOR.instances.event_content.insertHtml('<img src="'+src+'" alt="'+name_news+'"/>');
    }
</script>
