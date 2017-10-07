<?php
class TraCuuController extends BaseSiteController{
    public function __construct(){
        parent::__construct();
        FunctionLib::site_css('lib/jAlert/jquery.alerts.css', CGlobal::$POS_HEAD);
        FunctionLib::site_js('lib/jAlert/jquery.alerts.js', CGlobal::$POS_END);
    }
	public function traCuuVanBangChungChi(){
        //Meta title
        $meta_title='';
        $meta_keywords='';
        $meta_description='';
        $meta_img='';
        $arrMeta = Info::getItemByKeyword('SITE_SEO_TRACUU_VANBANG_CHUNGCHI');
        if(!empty($arrMeta)){
            $meta_title = $arrMeta->meta_title;
            $meta_keywords = $arrMeta->meta_keywords;
            $meta_description = $arrMeta->meta_description;
            $meta_img = $arrMeta->info_img;
            if($meta_img != ''){
                $meta_img = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrMeta->info_id, $arrMeta->info_img, 550, 0, '', true, true);
            }
        }
        FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);

        $this->header();
        $this->layout->content = View::make('site.SiteLayouts.pageTraCuuVanBangChungChi');
        $this->eduBottom();
        $this->sliderPartnerBottom();
        $this->footer();
	}
    public function ajaxTraCuuVanBangChungChi(){
        $dataSearch['vanbang_machungchi'] = (string)trim(stripslashes(Request::get('ipVanBang','')));
        $token = trim(stripslashes(Request::get('_token', '')));
        if(Session::token() === $token){
            if($dataSearch['vanbang_machungchi'] != ''){
                $tmp = str_replace(' ', '', $dataSearch['vanbang_machungchi']);
				$dataSearch['vanbang_machungchi'] = $tmp;
				$result = ExcelVanbang::searchSiteByCondition($dataSearch, 1);
                $arrItem = array();
                if(sizeof($result) > 0){
                    foreach($result as $item){
                        $tmp = array(
                            'vanbang_hoten'=>(string)$item->vanbang_hoten,
                            'vanbang_ngaysinh'=>(string)$item->vanbang_ngaysinh,
                            'vanbang_noisinh'=>(string)$item->vanbang_noisinh,
                            'vanbang_gioitinh'=>(string)$item->vanbang_gioitinh,
                            'vanbang_dantoc'=>(string)$item->vanbang_dantoc,
                            'vanbang_nganhdaotao'=>(string)$item->vanbang_nganhdaotao,
                            'vanbang_namtotnghiep'=>(string)$item->vanbang_namtotnghiep,
                            'vanbang_xeploai'=>(string)$item->vanbang_xeploai,
                            'vanbang_machungchi'=>(string)$item->vanbang_machungchi,
                            'vanbang_chungchiso'=>(string)$item->vanbang_chungchiso,
                            'vanbang_khoahoc'=>(string)$item->vanbang_khoahoc,
                            'vanbang_trinhdo'=>(string)$item->vanbang_trinhdo,
                            'vanbang_htdaotao'=>(string)$item->vanbang_htdaotao,
                            'vanbang_sototnghiep'=>(string)$item->vanbang_sototnghiep,
                            'vanbang_ngaytotnghiep'=>(string)$item->vanbang_ngaytotnghiep,
                        );
                        array_push($arrItem, $tmp);
                    }
                    echo json_encode($arrItem);die;
                }else{
                    echo '1';die;//Khong ton tai du lieu
                }
            }
        }
        echo '0';die;//Nhap thieu thong tin
    }
	public function traCuuDiemThiNangKhieu(){
        //Meta title
        $meta_title='';
        $meta_keywords='';
        $meta_description='';
        $meta_img='';
        $arrMeta = Info::getItemByKeyword('SITE_SEO_TRACUU_DIEMTHI_NANG_KHIEU');
        if(!empty($arrMeta)){
            $meta_title = $arrMeta->meta_title;
            $meta_keywords = $arrMeta->meta_keywords;
            $meta_description = $arrMeta->meta_description;
            $meta_img = $arrMeta->info_img;
            if($meta_img != ''){
                $meta_img = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrMeta->info_id, $arrMeta->info_img, 550, 0, '', true, true);
            }
        }
        FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);

        $this->header();
        $this->layout->content = View::make('site.SiteLayouts.pageTraCuuDiemThiNangKhieu');
        $this->eduBottom();
        $this->sliderPartnerBottom();
        $this->footer();
	}
    public function ajaxTraCuuDiemThiNangKhieu(){
        $dataSearch['nangkhieu_cmt'] = trim(stripslashes(Request::get('ipCMND','')));
        $dataSearch['nangkhieu_hoten'] = trim(stripslashes(Request::get('ipHoVaTen','')));
        $token = trim(stripslashes(Request::get('_token', '')));
        if(Session::token() === $token){
            if($dataSearch['nangkhieu_cmt'] != '' || $dataSearch['nangkhieu_hoten'] != ''){
                $result = ExcelNangkhieu::searchSiteByCondition($dataSearch, 100000);
                $arrItem = array();
                if(sizeof($result) > 0){
                    foreach($result as $item){
                        $tmp = array(
                            'nangkhieu_sobaodanh'=>(string)$item->nangkhieu_sobaodanh,
                            'nangkhieu_hoten'=>(string)$item->nangkhieu_hoten,
                            'nangkhieu_ngaysinh'=>(string)$item->nangkhieu_ngaysinh,
                            'nangkhieu_cmt'=>(string)$item->nangkhieu_cmt,
                            'nangkhieu_sophach'=>(string)$item->nangkhieu_sophach,
                            'nangkhieu_monthi_mot'=>(string)$item->nangkhieu_monthi_mot,
                            'nangkhieu_monthi_hai'=>(string)$item->nangkhieu_monthi_hai,
                            'nangkhieu_monthi_ba'=>(string)$item->nangkhieu_monthi_ba,
                            'nangkhieu_monthi_bon'=>(string)$item->nangkhieu_monthi_bon,
                            'nangkhieu_monthi_nam'=>(string)$item->nangkhieu_monthi_nam,
                            'nangkhieu_monthi_sau'=>(string)$item->nangkhieu_monthi_sau,
                            'nangkhieu_ngaythi'=>(string)$item->nangkhieu_ngaythi,
                        );
                        array_push($arrItem, $tmp);
                    }
                    echo json_encode($arrItem);die;
                }else{
                    echo '1';die;//Khong ton tai du lieu
                }
            }
        }
        echo '0';die;//Nhap thieu thong tin
    }

	public function traCuuXetTuyenSinh(){
        //Meta title
        $meta_title='';
        $meta_keywords='';
        $meta_description='';
        $meta_img='';
        $arrMeta = Info::getItemByKeyword('SITE_SEO_TRACUU_XET_TUYENSINH');
        if(!empty($arrMeta)){
            $meta_title = $arrMeta->meta_title;
            $meta_keywords = $arrMeta->meta_keywords;
            $meta_description = $arrMeta->meta_description;
            $meta_img = $arrMeta->info_img;
            if($meta_img != ''){
                $meta_img = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrMeta->info_id, $arrMeta->info_img, 550, 0, '', true, true);
            }
        }
        FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);

        $this->header();
        $this->layout->content = View::make('site.SiteLayouts.pageTraCuuXetTuyenSinh');
        $this->eduBottom();
        $this->sliderPartnerBottom();
        $this->footer();
	}
	public function ajaxTraCuuXetTuyenSinh(){
        $dataSearch['tuyensinh_cmt'] = trim(stripslashes(Request::get('ipCMND','')));
        $dataSearch['tuyensinh_hoten'] = trim(stripslashes(Request::get('ipHoVaTen','')));
        $dataSearch['tuyensinh_trinhdo'] = trim(stripslashes(Request::get('ipTrinhDo','')));
        $token = trim(stripslashes(Request::get('_token', '')));
        if(Session::token() === $token){
            if($dataSearch['tuyensinh_trinhdo'] == 1){
                $dataSearch['tuyensinh_trinhdo'] = 'Trung cấp';
            }elseif($dataSearch['tuyensinh_trinhdo'] == 2){
                $dataSearch['tuyensinh_trinhdo'] = 'Cao đẳng';
            }elseif($dataSearch['tuyensinh_trinhdo'] == 3){
                $dataSearch['tuyensinh_trinhdo'] = 'Cao đẳng liên thông';
            }else{
                $dataSearch['tuyensinh_trinhdo'] = '';
            }

            if(($dataSearch['tuyensinh_cmt'] != '' || $dataSearch['tuyensinh_hoten']) && $dataSearch['tuyensinh_trinhdo'] != ''){
                $result = ExcelTuyensinh::searchSiteByCondition($dataSearch, 100000);
                $arrItem = array();
                if(sizeof($result) > 0){
                    foreach($result as $item){
                        $tmp = array(
                            'tuyensinh_hoten'=>(string)$item->tuyensinh_hoten,
                            'tuyensinh_ngaysinh'=>(string)$item->tuyensinh_ngaysinh,
                            'tuyensinh_cmt'=>(string)$item->tuyensinh_cmt,
                            'tuyensinh_khuvuc_uutien'=>(string)$item->tuyensinh_khuvuc_uutien,
                            'tuyensinh_diem_uutien'=>(string)$item->tuyensinh_diem_uutien,
                            'tuyensinh_hinhthucxettuyen'=>(string)$item->tuyensinh_hinhthucxettuyen,
                            'tuyensinh_tongdiemco_uutien'=>(string)$item->tuyensinh_tongdiemco_uutien,
                            'tuyensinh_nganhtrungtuyen'=>(string)$item->tuyensinh_nganhtrungtuyen,
                            'tuyensinh_dotxettuyen'=>(string)$item->tuyensinh_dotxettuyen,

                        );
                        array_push($arrItem, $tmp);
                    }
                    echo json_encode($arrItem);die;
                }else{
                    echo '1';die;//Khong ton tai du lieu
                }
            }
        }
        echo '0';die;//Nhap thieu thong tin
    }
}