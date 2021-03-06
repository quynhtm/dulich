<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */
class CGlobal{
    static $css_ver = 1;
    static $js_ver = 1;
    public static $POS_HEAD = 1;
    public static $POS_END = 2;
    public static $extraHeaderCSS = '';
    public static $extraHeaderJS = '';
    public static $extraFooterCSS = '';
    public static $extraFooterJS = '';
    public static $extraMeta = '';
    public static $pageAdminTitle = 'Dashboard Admin';
    public static $pageShopTitle = 'CĐSPTW Admin';

    const web_name = 'Cdsptw.edu.vn';
    const web_keywords= 'Cao đẳng Trung ương';
    const web_description= 'Cao đẳng Trung ương';
    public static $pageTitle = 'Cao đẳng Trung ương';
    
    const num_scroll_page = 2;
    const number_limit_show = 30;
    const number_show_30 = 30;
    const number_show_40 = 40;
    const number_show_20 = 20;
    const number_show_15 = 15;
    const number_show_10 = 10;
    const number_show_5 = 5;
    const number_show_8 = 8;

    const max_num_buy_item_product = 10;
    /**
     * Dinh nghi kich thuoc anh Sản phẩm
     */
    const type_thumb_image_product = 1;
    const type_thumb_image_banner = 2;

    const sizeImage_80 = 80;
    const sizeImage_100 = 100;//dung common
    const sizeImage_150 = 150;
    const sizeImage_200 = 200;
    const sizeImage_300 = 300;
    const sizeImage_450 = 450;
    const sizeImage_500 = 500;
    const sizeImage_600 = 600;
    const sizeImage_750 = 750;
    const sizeImage_1020 = 1020;

    const sizeImage_1000 = 1000;
    const sizeImage_1010 = 1010;
    const sizeImage_90 = 90;//banner header

    const freeSizeImage_300 = 301;

    //size anh cho tin rao
    public static $arrSizeImage = array(
        self::sizeImage_80 =>array('w'=>self::sizeImage_80,'h'=>self::sizeImage_80),
        self::sizeImage_100 =>array('w'=>self::sizeImage_100,'h'=>self::sizeImage_100),
        self::sizeImage_150 =>array('w'=>self::sizeImage_150,'h'=>self::sizeImage_100),
        self::sizeImage_200 =>array('w'=>self::sizeImage_200,'h'=>self::sizeImage_150),
        self::sizeImage_300 =>array('w'=>self::sizeImage_300,'h'=>self::sizeImage_300),
    	self::sizeImage_600 =>array('w'=>self::sizeImage_600,'h'=>self::sizeImage_600),//insert vao noi dung
        self::sizeImage_750 =>array('w'=>self::sizeImage_750,'h'=>self::sizeImage_750),
        self::sizeImage_500 =>array('w'=>self::sizeImage_500,'h'=>self::sizeImage_300),
        self::sizeImage_1000 =>array('w'=>self::sizeImage_1000,'h'=>self::sizeImage_1000),
    );

    //dinh nghĩa khung ảnh hiển thị bên ngoài
    const size_imge_show_list_60 = ' height="60" width="120" ';
    const size_imge_show_list_150 = ' height="80" width="150" ';
    const size_imge_show_list_180 = ' height="180" width="300" ';
    const size_imge_show_detail = ' height="100" width="500" ';
    /**
     * Dinh nghi kich thuoc anh Banner
     */
    public static $arrBannerSizeImage = array(
        self::sizeImage_100 =>array('w'=>self::sizeImage_100,'h'=>self::sizeImage_100),
        self::sizeImage_200 =>array('w'=>self::sizeImage_200,'h'=>self::sizeImage_600),
        self::sizeImage_300 =>array('w'=>self::sizeImage_300,'h'=>self::sizeImage_300),
    	self::sizeImage_450 =>array('w'=>self::sizeImage_450,'h'=>self::sizeImage_450),
    	self::sizeImage_750 =>array('w'=>self::sizeImage_750,'h'=>self::sizeImage_450),
        self::sizeImage_1000 =>array('w'=>self::sizeImage_1000,'h'=>0),
    	self::sizeImage_1020 =>array('w'=>self::sizeImage_1020,'h'=>0),
    	self::freeSizeImage_300 =>array('w'=>self::freeSizeImage_300,'h'=>0),
    	1 =>array('w'=>self::sizeImage_1010,'h'=>self::sizeImage_90),//banner header
    );
	
    
    const status_show = 1;
    const status_hide = 0;
    const status_block = -1;

    //Danh mục cho trang chính của trường: Điều kiện = 0
    const status_cat_department_home = 0;

    //is_login Customer
    const not_login = 0;
    const is_login = 1;

    const province_id_hanoi = 22;

    //lien ket link
    const TYPE_LINK_COQUAN = 1;
    const TYPE_LINK_TRUONG = 2;
    const TYPE_LINK_WEBSITE = 3;

    //Tin tuc
    const NEW_CATEGORY_TIN_TUC_CHUNG = 1;
    const NEW_CATEGORY_GIOI_THIEU = 2;
    const NEW_CATEGORY_QUANG_CAO = 3;

    const NEW_TYPE_TIN_TUC = 1;
    const NEW_TYPE_TIN_HOT = 2;

    public static $arrCategoryNew = array(-1 => '--- Chọn danh mục ---',
        self::NEW_CATEGORY_TIN_TUC_CHUNG => 'Tin tức chung',
        self::NEW_CATEGORY_GIOI_THIEU => 'Tin giới thiệu',
        self::NEW_CATEGORY_QUANG_CAO => 'Tin quảng cáo',
    );
    public static $arrTypeNew = array(-1 => '--- Chọn kiểu tin ---',
        self::NEW_TYPE_TIN_TUC => 'Tin bình thường',
        self::NEW_TYPE_TIN_HOT => 'Tin nổi bật',
    );

    const TYPE_LANGUAGE_VIET = 1;
    const TYPE_LANGUAGE_LAO = 2;
    const TYPE_LANGUAGE_ENG = 3;
    public static $arrLanguage= array(
        self::TYPE_LANGUAGE_VIET => 'Viet Nam',
        self::TYPE_LANGUAGE_LAO => 'Lao',
        self::TYPE_LANGUAGE_ENG => 'English',
    );

    const IMAGE_ERROR = 133;
    const FOLDER_NEWS = 'news';
    const FOLDER_EVENT = 'eventNew';
    const FOLDER_BANNER = 'banner';
    const FOLDER_PRODUCT = 'product';
    const FOLDER_CATEGORY = 'category';
    const FOLDER_DEPART_LOGO = 'departLogo';
    const FOLDER_TAB_SUB = 'tabSub';
    const FOLDER_INFORSEO = 'inforSeo';
    const FOLDER_LIBRARY_IMAGE = 'libraryImage';
	const FOLDER_INFO = 'info';

    //shop
    const CUSTOMER_FREE = 1;
    const CUSTOMER_NOMAL = 2;
    const CUSTOMER_VIP = 3;
    const CUSTOMER_ONLINE = 1;
    const CUSTOMER_OFFLINE = 0;
    const CUSTOMER_GENDER_GIRL = 0;
    const CUSTOMER_GENDER_BOY = 1;

    //items
    const ITEMS_TYPE_ACTION_1 = 1; //1: Cần bán/ Tuyển sinh,
    const ITEMS_TYPE_ACTION_2 = 2; //2:Cần mua/ Tuyển dụng

    const TYPE_PRICE_NUMBER = 1;
    const TYPE_PRICE_CONTACT = 2;
    const ITEMS_NOMAL = 1;
    const ITEMS_HOT = 2;
    const ITEMS_SELLOFF = 3;
    const ITEMS_BLOCK = 0;
    const ITEMS_NOT_BLOCK = 1;


    //banner
    const BANNER_NOT_RUN_TIME = 0;
    const BANNER_IS_RUN_TIME = 1;
    const BANNER_NOT_TARGET_BLANK = 0;
    const BANNER_TARGET_BLANK = 1;

    const BANNER_TYPE_TOP = 1;
    const BANNER_TYPE_LEFT = 2;
    const BANNER_TYPE_RIGHT = 3;
    const BANNER_TYPE_BOTTOM = 4;
    const BANNER_TYPE_CENTER = 5;
    const BANNER_TYPE_SLIDE = 6;
    const BANNER_TYPE_CALENDAR_WEEK = 7;
    const BANNER_TYPE_PARTNER = 8;

    //page gắn link quảng cáo
    const BANNER_PAGE_HOME = 1;
    const BANNER_PAGE_DETAIL = 2;
    const BANNER_PAGE_CATEGORY = 3;
    const BANNER_PAGE_CUSTOMER_ITEMS = 4;
    const BANNER_PAGE_CONTACT = 5;
    const BANNER_PAGE_SEARCH = 6;
    const BANNER_PAGE_OTHER = 7;

    public static $arrPageCurrent = array(
        'index' => self::BANNER_PAGE_HOME,
        'pageListItemCustomer' => self::BANNER_PAGE_CUSTOMER_ITEMS,
        'pageCategory' => self::BANNER_PAGE_CATEGORY,
        'pageContact' => self::BANNER_PAGE_CONTACT,
        'searchItems' => self::BANNER_PAGE_SEARCH,

        'pageDetailItem' => self::BANNER_PAGE_DETAIL,
        'pageDetailNew' => self::BANNER_PAGE_DETAIL,

        'page404' => self::BANNER_PAGE_OTHER,
        'pageNews' => self::BANNER_PAGE_OTHER,
    );

    const LINK_NOFOLLOW = 0;
    const LINK_FOLLOW = 1;
   
    //Duy bo sung
    const emailAdmin = 'admin@cdsptw.edu.vn';
    
    public static $arrIconSpecals = array(
    	'\r\n', '☎', '👉', '✈', '🍬', '🏃', '🏻', '😁','🍬', '🏃🏻', '💃🏽', '✅', '😜', '🌳', '🌴', '🌲', '🌱',
    	'🌻', '🐮', '🐃', '🐎', '🐎', '🐓', '🐔', '🐗', '💥'
    );
    const linkMail = 'http://mail.cdsptw.edu.vn';
}