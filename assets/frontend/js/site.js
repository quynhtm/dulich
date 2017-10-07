jQuery(document).ready(function($){
	SITE.backTop();
	SITE.contact();
	SITE.captchaCheckAjax();
	SITE.tabEdu();
	SITE.boxTraCuuVanBangChungChi();
	SITE.boxTraCuuDiemThiNangKhieu();
	SITE.boxTraCuuXetTuyenSinh();
    SITE.menuMobile();
});

SITE={
	backTop:function(){
		jQuery(window).scroll(function() {
		    if(jQuery(window).scrollTop() > 0) {
				jQuery("#back-top").fadeIn();
			} else {
				jQuery("#back-top").fadeOut();
			}
		});
		jQuery("#back-top").click(function(){
			jQuery("html, body").animate({scrollTop: 0}, 1000);
			return false;
		});
	},
	contact:function(){
		jQuery('#submitContact').click(function(){
			var valid = true;
			if(jQuery('#txtName').val() == ''){
				jQuery('#txtName').addClass('error');
				valid = false;
			}else{
				jQuery('#txtName').removeClass('error');
			}
			
			if(jQuery('#txtMobile').val() == ''){
				jQuery('#txtMobile').addClass('error');
				valid = false;
			}else{
				
				var regex = /^[0-9-+]+$/;
				var phone = jQuery('#txtMobile').val();
				if (regex.test(phone)) {
			        jQuery('#txtMobile').removeClass('error');
			    }else{
					jQuery('#txtMobile').addClass('error');	
				}
			}
			if(jQuery('#txtTitle').val() == ''){
				jQuery('#txtTitle').addClass('error');
				valid = false;
			}else{
				jQuery('#txtTitle').removeClass('error');
			}
			if(jQuery('#txtMessage').val() == ''){
				jQuery('#txtMessage').addClass('error');
				valid = false;
			}else{
				jQuery('#txtMessage').removeClass('error');
			}
			
			if(jQuery('#securityCode').val() == ''){
				jQuery('#securityCode').addClass('error');
				valid = false;
			}else{
				SITE.captchaCheckAjax();
			}
			
			var error = jQuery('#formSendContact .error').length;
			if(error > 0){
				return false;
			}
			return valid;
		});
	},
	captchaCheckAjax:function(){
		var captcha = jQuery('#securityCode').val();
		if(captcha != ''){
			var url = WEB_ROOT + '/captchaCheckAjax';
			jQuery.ajax({
				type: "POST",
				url: url,
				data: "captcha="+encodeURI(captcha),
				success: function(data){
					if(data == 0){
						jQuery('#securityCode').addClass('error');
                        var img = document.images['imageCaptchar'];
                        if(img != undefined) {
                            img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.round(1000 * Math.random());
                        }
					}else{
						jQuery('#securityCode').removeClass('error');
					}
					return false;
				}
			});
		}
	},
    tabEdu:function(){
		$('#tabContaier ul li a').click(function(){
            $('#tabContaier ul li a').removeClass('active');
			$(this).addClass('active')
			var data = $(this).attr('data');
			if(data != ''){
				$('.tabContents').removeClass('active');
				$('#'+data).addClass('active');
			}
		});
	},
    boxTraCuuVanBangChungChi:function(){
        $(document).keypress(function(e) {
            if((e.keyCode ? e.keyCode : e.which) == 13){
                $('#submitTraCuuVanBangChungChi').click();
                return false;
            }
        });
        $('#submitTraCuuVanBangChungChi').click(function(){
    		var ipVanBang = $('#ipVanBang').val(),
                _token = $('#formTraCuu input[name="_token"]').val();
    		if(ipVanBang == ''){
               jAlert('Nhập văn bằng hoặc chứng chỉ', 'Cảnh báo');
			}else{
                if(_token != '') {
                    $('.loading').show();
                    var url = WEB_ROOT + '/ajax-tra-cuu-van-bang-chung-chi';
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: "ipVanBang=" + encodeURI(ipVanBang) + "&_token=" + encodeURI(_token),
                        success: function (data) {
                            $('.loading').hide();
                            $('.box-list-equal').html('');
                            if (data == '0') {
                                jAlert('Nhập văn bằng hoặc chứng chỉ', 'Cảnh báo');
                            } else if (data == '1') {
                                $('.box-list-equal').append('<div class="noResult">Không có kết quả nào phù hợp.</div>');
                            } else {
                                var jsonData = jQuery.parseJSON(data);
                                var str = '';
                                str += '<table class="tblNangKhieu">';
								for (var i = 0; i < jsonData.length; i++) {
                                    str += '<tr><td><b>Họ và tên:</b> '+ jsonData[i].vanbang_hoten +'</td><td><b>Ngày sinh:</b> ' + jsonData[i].vanbang_ngaysinh + '</td><td><b>Nơi sinh:</b> ' + jsonData[i].vanbang_noisinh + '</td><td><b>Giới tính:</b> ' + jsonData[i].vanbang_gioitinh + '</td><td><b>Dân tộc:</b> ' + jsonData[i].vanbang_dantoc + '</td></tr><tr><td><b>Ngành đào tạo:</b> ' + jsonData[i].vanbang_nganhdaotao + '</td><td><b>Khóa:</b> ' + jsonData[i].vanbang_khoahoc + '</td><td><b>Hình thức ĐT:</b> ' + jsonData[i].vanbang_htdaotao + '</td><td><b>Năm TN:</b> ' + jsonData[i].vanbang_namtotnghiep + '</td><td><b>Xếp loại:</b> ' + jsonData[i].vanbang_xeploai + '</td></tr><tr><td><b>Số Quyết định:</b> ' + jsonData[i].vanbang_sototnghiep + '</td><td><b>Ngày Quyết định:</b> ' + jsonData[i].vanbang_ngaytotnghiep + '</td><td><b>Số hiệu VBCC:</b> ' + jsonData[i].vanbang_machungchi + '</td><td><b>Số vào sổ:</b> ' + jsonData[i].vanbang_chungchiso + '</td><td></td></tr>';
                                }
								str += '</table>';
                                $('.box-list-equal').append(str);
                            }
                        }
                    });
                }
			}
		});
	},
    boxTraCuuDiemThiNangKhieu:function(){
        $(document).keypress(function(e) {
            if((e.keyCode ? e.keyCode : e.which) == 13){
                $('#submitTraCuuDiemThiNangKhieu').click();
                return false;
            }
        });
        $('#submitTraCuuDiemThiNangKhieu').click(function(){
            var ipCMND = $('#ipCMND').val(),
                ipHoVaTen = $('#ipHoVaTen').val(),
                _token = $('#formTraCuu input[name="_token"]').val();

            if(ipCMND == '' && ipHoVaTen == ''){
                jAlert('Nhập số CMND hoặc Họ và tên', 'Cảnh báo');
            }else{
                if(_token != '') {
                    $('.loading').show();
                    var url = WEB_ROOT + '/ajax-tra-cuu-diem-thi-nang-khieu';
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: "ipCMND=" + encodeURI(ipCMND) + "&ipHoVaTen=" + encodeURI(ipHoVaTen) + "&_token=" + encodeURI(_token),
                        success: function (data) {
                            $('.loading').hide();
                            $('.box-list-equal').html('');
                            if (data == '0') {
                                jAlert('Nhập số CMND hoặc Họ và tên', 'Cảnh báo');
                            } else if (data == '1') {
                                $('.box-list-equal').append('<div class="noResult">Không có kết quả nào phù hợp.</div>');
                            } else {
                                var jsonData = jQuery.parseJSON(data);
                                var str = '';
								str += '<table class="tblNangKhieu">';
                                str += '<tr class="head"><td width="20%">Họ và tên</td><td width="10%">Ngày sinh</td><td width="10%">Số CMND</td><td width="10%">NK1</td><td width="10%">NK2</td><td width="10%">NK3</td><td width="10%">NK4</td><td width="10%">NK5</td><td width="10%">NK6</td><td width="10%">Đợt thi</td></tr>';
                                for (var i = 0; i < jsonData.length; i++) {
                                    str += '<tr><td>'+jsonData[i].nangkhieu_hoten+'</td><td>'+ jsonData[i].nangkhieu_ngaysinh +'</td><td>'+ jsonData[i].nangkhieu_cmt +'</td><td>'+ jsonData[i].nangkhieu_monthi_mot +'</td><td>'+ jsonData[i].nangkhieu_monthi_hai +'</td><td>'+ jsonData[i].nangkhieu_monthi_ba +'</td><td>'+ jsonData[i].nangkhieu_monthi_bon +'</td><td>'+ jsonData[i].nangkhieu_monthi_nam +'</td><td>'+ jsonData[i].nangkhieu_monthi_sau +'</td><td>'+ jsonData[i].nangkhieu_ngaythi +'</td></tr>';
                                }
								str += '</table>';
                                str += '<div class="line-equal-item"><div class="col-lg-6 col-md-6 col-sm-12 ext-items"><div class="item-form-group"> <label class="control-label">NK 1: <span class="normal">Đọc, kể diễn cảm và Hát</span></label></div><div class="item-form-group"> <label class="control-label">NK2: <span class="normal">Thẩm âm-Tiết tấu</span></label></div><div class="item-form-group"> <label class="control-label">NK3: <span class="normal">Thanh nhạc</span></label></div></div><div class="col-lg-6 col-md-6 col-sm-12 ext-items"><div class="item-form-group"> <label class="control-label">NK4: <span class="normal">Hình họa</span></label></div><div class="item-form-group"> <label class="control-label">NK5: <span class="normal">Bố cục</span></label></div><div class="item-form-group"> <label class="control-label">NK6: <span class="normal">Trang trí</span></label></div></div></div>';
                                $('.box-list-equal').append(str);
                            }
                        }
                    });
                }
            }
        });
    },
    boxTraCuuXetTuyenSinh:function(){
        $(document).keypress(function(e) {
            if((e.keyCode ? e.keyCode : e.which) == 13){
                $('#submitTraCuuXetTuyenSinh').click();
                return false;
            }
        });
        $('#submitTraCuuXetTuyenSinh').click(function(){
            var ipCMND = $('#ipCMND').val(),
                ipHoVaTen = $('#ipHoVaTen').val(),
                ipTrinhDo = $('#ipTrinhDo').val(),
                _token = $('#formTraCuu input[name="_token"]').val();
            if((ipCMND == '' || ipHoVaTen) == '' && ipTrinhDo == ''){
                jAlert('Nhập số CMND hoặc Họ và tên', 'Cảnh báo');
            }else{
                if(_token != '') {
                    $('.loading').show();
                    var url = WEB_ROOT + '/ajax-tra-cuu-ket-qua-tuyen-sinh';
                    jQuery.ajax({
                        type: "POST",
                        url: url,
                        data: "ipCMND=" + encodeURI(ipCMND) + "&ipHoVaTen=" + encodeURI(ipHoVaTen) + "&ipTrinhDo=" + encodeURI(ipTrinhDo) + "&_token=" + encodeURI(_token),
                        success: function (data) {
                            $('.loading').hide();
                            $('.box-list-equal').html('');
                            if (data == '0') {
                                jAlert('Nhập số CMND hoặc Họ và tên', 'Cảnh báo');
                            } else if (data == '1') {
                                $('.box-list-equal').append('<div class="noResult">Không có kết quả nào phù hợp.</div>');
                            } else {
                                var jsonData = jQuery.parseJSON(data);
                                var str = '';
                                str += '<table class="tblNangKhieu">';
                                str += '<tr class="head"><td>Họ và tên</td><td>Ngày sinh</td><td>Số CMND</td><td>Khu vực</td><td>Đối tượng</td><td>Hình thức xét tuyển</td><td>Tổng điểm có ƯT</td><td>Ngành trúng tuyển</td><td>Đợt xét tuyển</td></tr>';
                                for (var i = 0; i < jsonData.length; i++) {
                                    str += '<tr><td>'+jsonData[i].tuyensinh_hoten+'</td><td>'+ jsonData[i].tuyensinh_ngaysinh +'</td><td>'+ jsonData[i].tuyensinh_cmt +'</td><td>'+ jsonData[i].tuyensinh_khuvuc_uutien +'</td><td>'+ jsonData[i].tuyensinh_diem_uutien +'</td><td>'+ jsonData[i].tuyensinh_hinhthucxettuyen +'</td><td>'+ jsonData[i].tuyensinh_tongdiemco_uutien +'</td><td>'+ jsonData[i].tuyensinh_nganhtrungtuyen +'</td><td>' + jsonData[i].tuyensinh_dotxettuyen + '</td></tr>';
                                }
                                str += '</table>';
                                $('.box-list-equal').append(str);
                            }
                        }
                    });
                }
            }
        });
    },
    menuMobile:function(){
        $('#toggle-menu').click(function(){
            $('.bg-menu').addClass('act');
            $('#toggle-menu').hide();
        });
        $('.icon-close').click(function(){
            $('.bg-menu').removeClass('act');
            $('#toggle-menu').show();
        });
    },
}