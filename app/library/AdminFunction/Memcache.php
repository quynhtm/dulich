<?php
class Memcache{
    const CACHE_ON = 1 ;// 0: khong dung qua cache, 1: dung qua cache
    const CACHE_TIME_TO_LIVE_5 = 300; //Time cache 5 phut
    const CACHE_TIME_TO_LIVE_15 = 900; //Time cache 15 phut
    const CACHE_TIME_TO_LIVE_30 = 1800; //Time cache 30 phut
    const CACHE_TIME_TO_LIVE_60 = 3600; //Time cache 60 phut

    const CACHE_TIME_TO_LIVE_ONE_DAY = 86400; //Time cache 1 ngay
    const CACHE_TIME_TO_LIVE_ONE_WEEK = 604800; //Time cache 1 tuan
    const CACHE_TIME_TO_LIVE_ONE_MONTH = 2419200; //Time cache 1 thang
    const CACHE_TIME_TO_LIVE_ONE_YEAR =  29030400; //Time cache 1 nam

    //user customer
    const CACHE_ALL_CUSTOMER = 'cache_all_customer';
    const CACHE_CUSTOMER_ID = 'cache_customer_id_';

    //danh mục
    const CACHE_ALL_CATEGORY    = 'cache_all_category';
    const CACHE_ALL_PARENT_CATEGORY    = 'cache_all_parent_category';
    const CACHE_ALL_SHOW_CATEGORY_FRONT    = 'cache_all_show_category_front';
    const CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID    = 'cache_all_child_by_parent_id_';
    const CACHE_CATEGORY_ID    = 'cache_category_id_';

    //depart
    const CACHE_DEPARTMENT_ID    = 'cache_department_id_';
    const CACHE_ALL_DEPARTMENT    = 'cache_all_department';
    const CACHE_LIST_DEPARTMENT    = 'cache_list_department';
    //tab
    const CACHE_ALL_TAB    = 'cache_all_tab';
    const CACHE_ALL_TAB_LINK    = 'cache_all_tab_link';
    const CACHE_ALL_SUB_TAB_PARENT    = 'cache_all_sub_tab_parent_';

    //depart
    const CACHE_TYPE_SETTING_ID    = 'cache_type_setting_id_';
    const CACHE_GROUP_TYPE_SETTING    = 'cache_group_type_setting_';
    const CACHE_KEYWORD_TYPE_SETTING    = 'cache_keyword_type_setting_';

    //depart
    const CACHE_CATEGORY_DEPARTMENT_ID    = 'cache_category_depart_id_';

    //tin đăng
    const CACHE_ITEM_ID    = 'cache_item_id_';
    const CACHE_ITEM_HOME_CATEGORY_ID   = 'cache_item_home_category_id_';

    //tin tức
    const CACHE_NEW_ID    = 'cache_news_id_';

    //tin tức
    const CACHE_EVENT_ID    = 'cache_event_id_';

    //share
    const CACHE_SHARE_OBJECT_ID    = 'cache_share_object_id_';

    //video
    const CACHE_VIDEO_ID    = 'cache_video_id_';

    //thu vien anh
    const CACHE_IMAGE_ID    = 'cache_image_id_';

    //banner
    const CACHE_BANNER_ID    = 'cache_banner_id_';
    const CACHE_BANNER_ADVANCED    = 'cache_banner_advanced';

    //Tinh thanh
    const CACHE_ALL_PROVICE = 'cache_all_provice';
    const CACHE_PROVICE_ID = 'cache_provice_id_';
    //Thong tin co ban: hotline, dia chi chan trang...
    const CACHE_INFO_ID    = 'cache_info_id_';
    const CACHE_INFO_KEYWORD    = 'cache_info_keyword_';
    //Thung rac
    const CACHE_TRASH_ID    = 'cache_trash_id_';

    //attack link
    const CACHE_ATTACK_LINK_ID    = 'cache_attack_link_id_';

    //Tinh thành
    const CACHE_ALL_PROVINCE = 'cache_all_province';
    const CACHE_PROVINCE_ID = 'cache_province_id_';

    //quan huyen
    const CACHE_DISTRICT_ID = 'cache_district_id_';
    const CACHE_DISTRICT_WITH_PROVINCE_ID = 'cache_district_with_province_id_';

    //Van bang
    const CACHE_VANBANG_ID    = 'cache_vanbang_id_';
    //Tuyen sinh
    const CACHE_TUYENSINH_ID    = 'cache_tuyensinh_id_';
    //Nang khieu
    const CACHE_NANGKHIEU_ID    = 'cache_nangkhieu_id_';
}
