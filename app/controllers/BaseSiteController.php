<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

class BaseSiteController extends BaseController{
    protected $layout = 'site.BaseLayouts.index';
   
    public function __construct(){
        FunctionLib::site_css('font-awesome/4.2.0/css/font-awesome.min.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_js('frontend/js/site.js', CGlobal::$POS_END);
    }

    public function header($logo='', $departmentId = CGlobal::status_cat_department_home, $itemDepartment=array()){
        //Banner Header
        $arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_TOP);
        $arrBannerHead = $this->getBannerWithPosition($arrBanner);
        //List Category
        $menuCategoriessAll = Category::getCategoriessAll();
        //Num Category Show Menu Horizontal
        $numCategory = 0;
        $numCategoryShow = Info::getItemByKeyword('SITE_NUM_MENU_HORIZONTAL');
        if(sizeof($numCategoryShow) > 0){
            $numCategory = (int)strip_tags(stripslashes($numCategoryShow->info_content));
        }

        $this->layout->header = View::make("site.BaseLayouts.header")
                                ->with('logo', $logo)
                                ->with('departmentId', $departmentId)
                                ->with('itemDepartment', $itemDepartment)
                                ->with('menuCategoriessAll', $menuCategoriessAll)
                                ->with('numCategory', $numCategory)
                                ->with('arrBannerHead', $arrBannerHead);
    }
	public function footer(){
        $footer = '';
        $arrFooter = Info::getItemByKeyword('SITE_FOOTER_LEFT');
        if(sizeof($arrFooter) > 0){
            $footer = stripslashes($arrFooter->info_content);
        }
		$this->layout->footer = View::make("site.BaseLayouts.footer")->with('footer', $footer);
	}
    public function slider($departmentId = CGlobal::status_cat_department_home, $itemDepartment=array()){

        FunctionLib::site_css('lib/skitter-master/skitter.css', CGlobal::$POS_HEAD);
        FunctionLib::site_js('lib/skitter-master/jquery.easing.1.3.js', CGlobal::$POS_END);
        FunctionLib::site_js('lib/skitter-master/jquery.skitter.min.js', CGlobal::$POS_END);

        $arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_SLIDE, $departmentId);
        $arrBannerSlider = $this->getBannerWithPosition($arrBanner);
        $this->layout->slider = View::make("site.BaseLayouts.slider")
                                ->with('departmentId', $departmentId)
                                ->with('itemDepartment', $itemDepartment)
                                ->with('arrBannerSlider', $arrBannerSlider);
    }
    public function left($departmentId = CGlobal::status_cat_department_home, $itemDepartment=array()){
        //List category right
        $menuCategoriessAll = Category::getCategoriessAll();
        //Banner Calendar Week
        $arrBannerWeeks = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_CALENDAR_WEEK);
        $arrBannerWeek = $this->getBannerWithPosition($arrBannerWeeks);
        //Banner Bottom
        $arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_LEFT, $departmentId);
        $arrBannerLeft = $this->getBannerWithPosition($arrBanner);
        $this->layout->left = View::make("site.BaseLayouts.left")
                                ->with('departmentId', $departmentId)
                                ->with('itemDepartment', $itemDepartment)
                                ->with('menuCategoriessAll', $menuCategoriessAll)
                                ->with('arrBannerLeft', $arrBannerLeft)
                                ->with('arrBannerWeek', $arrBannerWeek);
    }
    public function right($departmentId = CGlobal::status_cat_department_home, $itemDepartment=array()){
        //List type khoa-phongban-trungtam
        $arrType = TypeSetting::getTypeSettingWithGroup('group_type');
        $arrDepartment = Department::getFullDepart();
        //Link
        $arrLink = AttackLink::searchByConditionSite(array(), CGlobal::number_show_40);

        //List category right
        $menuCategoriessAll = Category::getCategoriessAll();
        $arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $departmentId);
        $arrBannerRight = $this->getBannerWithPosition($arrBanner);
        $this->layout->right = View::make("site.BaseLayouts.right")
                                ->with('departmentId', $departmentId)
                                ->with('itemDepartment', $itemDepartment)
                                ->with('arrType', $arrType)
                                ->with('arrDepartment', $arrDepartment)
                                ->with('menuCategoriessAll', $menuCategoriessAll)
                                ->with('arrBannerRight', $arrBannerRight)
                                ->with('arrLink', $arrLink);
    }
    public function eduBottom(){
        //Tab: Tuyển sinh và đào tạo
        $numTab = 0;
        $numTabShow = Info::getItemByKeyword('SITE_NUM_TAB_EDU_HOME');
        if(sizeof($numTabShow) > 0){
            $numTab = (int)strip_tags(stripslashes($numTabShow->info_content));
        }
        $arrTab = Tab::searchTabLimitAsc($numTab);
        //Tab fix
        $catTabFix = 0;
        $arrTabFixShow = Info::getItemByKeyword('SITE_CATID_TUYENSINH_DAOTAO_FIX_CUNG');
        if(sizeof($arrTabFixShow) > 0){
            $catTabFix = (int)strip_tags(stripslashes($arrTabFixShow->info_content));
        }
        $this->layout->eduBottom = View::make("site.BaseLayouts.eduBottom")
                                ->with('arrTab', $arrTab)
                                ->with('catTabFix', $catTabFix);
    }
    public function imagesVideoBottom(){
        //Thư viện video
        $dataFieldVideo['video_hot'] = CGlobal::NEW_TYPE_TIN_HOT;
        $dataFieldVideo['field_get'] = 'video_id,video_name,video_link';
        $arrVideo = Video::getNewVideo($dataFieldVideo, 1, 0);

        //Thư viện ảnh
        $dataFieldImg['image_hot'] = CGlobal::NEW_TYPE_TIN_HOT;
        $dataFieldImg['field_get'] = 'image_id,image_title,image_image_other';
        $arrImg = LibraryImage::getNewImages($dataFieldImg, 1, 0);
        if(sizeof($arrImg) > 0){
            FunctionLib::site_css('lib/slider-pro/slider-pro.min.css', CGlobal::$POS_HEAD);
            FunctionLib::site_js('lib/slider-pro/jquery.sliderPro.min.js', CGlobal::$POS_END);
        }

        $this->layout->imagesVideoBottom = View::make("site.BaseLayouts.imagesVideoBottom")
                                            ->with('arrVideo', $arrVideo)
                                            ->with('arrImg', $arrImg);
    }
    public function sliderPartnerBottom(){
        $arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_PARTNER);
        $arrBannerPartner = $this->getBannerWithPosition($arrBanner);
        if(sizeof($arrBannerPartner) > 0) {
            FunctionLib::site_js('lib/owl.carousel/owl.carousel.min.js', CGlobal::$POS_END);
            FunctionLib::site_css('lib/owl.carousel/owl.carousel.css', CGlobal::$POS_HEAD);
        }

        $this->layout->sliderPartnerBottom = View::make("site.BaseLayouts.partnerBottom")
                                ->with('arrBannerPartner', $arrBannerPartner);
    }

    public function getBannerWithPosition($arrBanner = array()){
        $arrBannerShow = array();
        if(sizeof($arrBanner) > 0){
            foreach($arrBanner as $id_banner =>$valu){
                $banner_is_run_time = 1;
                if($valu->banner_is_run_time == CGlobal::BANNER_NOT_RUN_TIME){
                    $banner_is_run_time = 1;
                }else{
                    $banner_start_time = $valu->banner_start_time;
                    $banner_end_time = $valu->banner_end_time;
                    $date_current = time();
                    if($banner_start_time > 0 && $banner_end_time > 0 && $banner_start_time <= $banner_end_time){
                        if($banner_start_time <= $date_current && $date_current <= $banner_end_time){
                            $banner_is_run_time = 1;
                        }
                    }else{
                        $banner_is_run_time = 0;
                    }
                }
                if($banner_is_run_time == 1){
                    $arrBannerShow[$valu->banner_id] = $valu;
                }
            }
        }
        return $arrBannerShow;
    }
    public function getCategoryAndPostByKeyword($cat_keyword='', $limit_post=0, $get_a_cat=0){
        $result = array();
        if($cat_keyword != '' && $limit_post>0){
            $result_cat = Info::getItemByKeyword($cat_keyword);
            if(sizeof($result_cat) > 0){
                $catid = strip_tags(stripslashes($result_cat->info_content));
                if($catid != '') {
                    if ($get_a_cat == 1){
                        $dataCat = Category::getByID($catid);
                        if (sizeof($dataCat) > 0) {
                            //Data Category
                            $result['cat'] = array(
                                'category_id' => $dataCat->category_id,
                                'category_name' => $dataCat->category_name,
                                'category_link' => $dataCat->category_link,
                            );
                        }
                    }
                    //Data Post In Category
                    $arrPost = News::getPostInCategoryParent($catid, $limit_post);
                    $result['post'] = $arrPost;
                }
            }
        }
        return $result;
    }
    public static function getPostInCategoryId($cat_id=0, $limit_post=0){
        $result = array();
        if($cat_id > 0 && $limit_post > 0){
            $arrCats = array();
            Category::makeListCatId($cat_id, 0, $arrCats);
            $arrCats[] = $cat_id;
            if(sizeof($arrCats) > 0){
                $arrCat = implode(',', $arrCats);
                $arrPost = News::getPostInCategoryParent($arrCat, $limit_post);
                $result = $arrPost;
            }
        }
        return $result;
    }
}