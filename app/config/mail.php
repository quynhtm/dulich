<?php
return array(
	'driver' => 'smtp',
	'host' => 'lhost.vpscloud.com.vn',
	'port' => 25,
    'from' => array('address' => 'no-reply@cdsptw.edu.vn', 'name' => ucwords(CGlobal::web_name)),
    'username' => 'no-reply@shopcuaem.com',
    'password' => 'TMEV+F&HE!Vq',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,
);