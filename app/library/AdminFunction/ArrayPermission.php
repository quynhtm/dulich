<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */
class ArrayPermission{
    public static $arrPermit = array(
        'root' => array('name_permit'=>'Quản trị site','group_permit'=>'Quản trị site'),//admin site
        'is_boss' => array('name_permit'=>'Boss','group_permit'=>'Boss'),//tech dùng quyen cao nhat

        'user_view' => array('name_permit'=>'Xem danh sách user Admin','group_permit'=>'Tài khoản Admin'),
        'user_create' => array('name_permit'=>'Tạo user Admin','group_permit'=>'Tài khoản Admin'),
        'user_edit' => array('name_permit'=>'Sửa user Admin','group_permit'=>'Tài khoản Admin'),
        'user_change_pass' => array('name_permit'=>'Thay đổi user Admin','group_permit'=>'Tài khoản Admin'),
        'user_remove' => array('name_permit'=>'Xóa user Admin','group_permit'=>'Tài khoản Admin'),

        'group_user_view' => array('name_permit'=>'Xem nhóm quyền','group_permit'=>'Nhóm quyền'),
        'group_user_create' => array('name_permit'=>'Tạo nhóm quyền','group_permit'=>'Nhóm quyền'),
        'group_user_edit' => array('name_permit'=>'Sửa nhóm quyền','group_permit'=>'Nhóm quyền'),

        'permission_full' => array('name_permit'=>'Full tạo quyền','group_permit'=>'Tạo quyền'),
        'permission_create' => array('name_permit'=>'Tạo tạo quyền','group_permit'=>'Tạo quyền'),
        'permission_edit' => array('name_permit'=>'Sửa tạo quyền','group_permit'=>'Tạo quyền'),

        'banner_full' => array('name_permit'=>'Full quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_view' => array('name_permit'=>'Xem quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_delete' => array('name_permit'=>'Xóa quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_create' => array('name_permit'=>'Tạo quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_edit' => array('name_permit'=>'Sửa quảng cáo','group_permit'=>'Quyền quảng cáo'),

        'category_full' => array('name_permit'=>'Full danh mục','group_permit'=>'Quyền danh mục'),
        'category_view' => array('name_permit'=>'Xem danh mục','group_permit'=>'Quyền danh mục'),
        'category_delete' => array('name_permit'=>'Xóa danh mục','group_permit'=>'Quyền danh mục'),
        'category_create' => array('name_permit'=>'Tạo danh mục','group_permit'=>'Quyền danh mục'),
        'category_edit' => array('name_permit'=>'Sửa danh mục','group_permit'=>'Quyền danh mục'),

        'department_full' => array('name_permit'=>'Full Khoa','group_permit'=>'Quyền Khoa'),
        'department_view' => array('name_permit'=>'Xem Khoa','group_permit'=>'Quyền Khoa'),
        'department_delete' => array('name_permit'=>'Xóa Khoa','group_permit'=>'Quyền Khoa'),
        'department_create' => array('name_permit'=>'Tạo Khoa','group_permit'=>'Quyền Khoa'),
        'department_edit' => array('name_permit'=>'Sửa Khoa','group_permit'=>'Quyền Khoa'),

        'category_depart_full' => array('name_permit'=>'Full danh mục Khoa','group_permit'=>'Quyền danh mục Khoa'),
        'category_depart_view' => array('name_permit'=>'Xem danh mục Khoa','group_permit'=>'Quyền danh mục Khoa'),
        'category_depart_delete' => array('name_permit'=>'Xóa danh mục Khoa','group_permit'=>'Quyền danh mục Khoa'),
        'category_depart_create' => array('name_permit'=>'Tạo danh mục Khoa','group_permit'=>'Quyền danh mục Khoa'),
        'category_depart_edit' => array('name_permit'=>'Sửa danh mục Khoa','group_permit'=>'Quyền danh mục Khoa'),

        'items_full' => array('name_permit'=>'Full tin rao','group_permit'=>'Quyền tin rao'),
        'items_view' => array('name_permit'=>'Xem tin rao','group_permit'=>'Quyền tin rao'),
        'items_delete' => array('name_permit'=>'Xóa tin rao','group_permit'=>'Quyền tin rao'),
        'items_create' => array('name_permit'=>'Tạo tin rao','group_permit'=>'Quyền tin rao'),
        'items_edit' => array('name_permit'=>'Sửa tin rao','group_permit'=>'Quyền tin rao'),

        'news_full' => array('name_permit'=>'Full tin tức','group_permit'=>'Quyền tin tức'),
        'news_view' => array('name_permit'=>'Xem tin tức','group_permit'=>'Quyền tin tức'),
        'news_delete' => array('name_permit'=>'Xóa tin tức','group_permit'=>'Quyền tin tức'),
        'news_create' => array('name_permit'=>'Tạo tin tức','group_permit'=>'Quyền tin tức'),
        'news_edit' => array('name_permit'=>'Sửa tin tức','group_permit'=>'Quyền tin tức'),

        'province_full' => array('name_permit'=>'Full tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_view' => array('name_permit'=>'Xem tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_delete' => array('name_permit'=>'Xóa tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_create' => array('name_permit'=>'Tạo tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_edit' => array('name_permit'=>'Sửa tỉnh thành','group_permit'=>'Quyền tỉnh thành'),

        'user_customer_full' => array('name_permit'=>'Full khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_view' => array('name_permit'=>'Xem khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_delete' => array('name_permit'=>'Xóa khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_create' => array('name_permit'=>'Tạo khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_edit' => array('name_permit'=>'Sửa khách hàng','group_permit'=>'Quyền khách hàng'),

        'event_full' => array('name_permit'=>'Full sự kiện','group_permit'=>'Quyền sự kiện'),
        'event_view' => array('name_permit'=>'Xem sự kiện','group_permit'=>'Quyền sự kiện'),
        'event_create' => array('name_permit'=>'Tạo sự kiện','group_permit'=>'Quyền sự kiện'),
        'event_edit' => array('name_permit'=>'Sửa sự kiện','group_permit'=>'Quyền sự kiện'),
        'event_delete' => array('name_permit'=>'Xóa sự kiện','group_permit'=>'Quyền sự kiện'),

        'infor_full' => array('name_permit'=>'Full thông tin','group_permit'=>'Quyền thông tin'),
        'infor_view' => array('name_permit'=>'Xem thông tin','group_permit'=>'Quyền thông tin'),
        'infor_create' => array('name_permit'=>'Tạo thông tin','group_permit'=>'Quyền thông tin'),
        'infor_edit' => array('name_permit'=>'Sửa thông tin','group_permit'=>'Quyền thông tin'),
        'infor_delete' => array('name_permit'=>'Xóa thông tin','group_permit'=>'Quyền thông tin'),

        'libraryImage_full' => array('name_permit'=>'Full thư viện ảnh','group_permit'=>'Quyền thư viện ảnh'),
        'libraryImage_view' => array('name_permit'=>'Full thư viện ảnh','group_permit'=>'Quyền thư viện ảnh'),
        'libraryImage_create' => array('name_permit'=>'Full thư viện ảnh','group_permit'=>'Quyền thư viện ảnh'),
        'libraryImage_edit' => array('name_permit'=>'Full thư viện ảnh','group_permit'=>'Quyền thư viện ảnh'),
        'libraryImage_delete' => array('name_permit'=>'Full thư viện ảnh','group_permit'=>'Quyền thư viện ảnh'),

        'tab_full' => array('name_permit'=>'Full','group_permit'=>'Quyền danh mục tab'),
        'tab_view' => array('name_permit'=>'Xem danh mục tab','group_permit'=>'Quyền danh mục tab'),
        'tab_create' => array('name_permit'=>'Tạo danh mục tab','group_permit'=>'Quyền danh mục tab'),
        'tab_edit' => array('name_permit'=>'Sửa danh mục tab','group_permit'=>'Quyền danh mục tab'),
        'tab_delete' => array('name_permit'=>'Xóa danh mục tab','group_permit'=>'Quyền danh mục tab'),

        'video_full' => array('name_permit'=>'Full video','group_permit'=>'Quyền video'),
        'video_view' => array('name_permit'=>'Xem video','group_permit'=>'Quyền video'),
        'video_create' => array('name_permit'=>'Tạo video','group_permit'=>'Quyền video'),
        'video_edit' => array('name_permit'=>'Sửa video','group_permit'=>'Quyền video'),
        'video_delete' => array('name_permit'=>'Xóa video','group_permit'=>'Quyền video'),

        'attackLink_full' => array('name_permit'=>'Full liên kết','group_permit'=>'Quyền liên kết'),
        'attackLink_view' => array('name_permit'=>'View liên kết','group_permit'=>'Quyền liên kết'),
        'attackLink_delete' => array('name_permit'=>'Xóa liên kết','group_permit'=>'Quyền liên kết'),
        'attackLink_create' => array('name_permit'=>'Tạo liên kết','group_permit'=>'Quyền liên kết'),
        'attackLink_edit' => array('name_permit'=>'Sửa liên kết','group_permit'=>'Quyền liên kết'),

        'excel_full' => array('name_permit'=>'Full excel','group_permit'=>'Quyền excel'),
        'excel_view' => array('name_permit'=>'View excel','group_permit'=>'Quyền excel'),
        'excel_delete' => array('name_permit'=>'Xóa excel','group_permit'=>'Quyền excel'),
        'excel_create' => array('name_permit'=>'Tạo excel','group_permit'=>'Quyền excel'),
        'excel_edit' => array('name_permit'=>'Sửa excel','group_permit'=>'Quyền excel'),

        'contract_full' => array('name_permit'=>'Full liên hệ','group_permit'=>'Quyền liên hệ'),
        'contract_view' => array('name_permit'=>'Xem liên hệ','group_permit'=>'Quyền liên hệ'),
        'contract_delete' => array('name_permit'=>'Xóa liên hệ','group_permit'=>'Quyền liên hệ'),
        'contract_create' => array('name_permit'=>'Tạo liên hệ','group_permit'=>'Quyền liên hệ'),
        'contract_edit' => array('name_permit'=>'Sửa liên hệ','group_permit'=>'Quyền liên hệ'),
    );

}