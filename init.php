<?php 
require 'include/db_class.php';
$db = new DB_class();

$sql = 'Create table user(id int auto_increment primary key,username varchar(100) not null,password varchar(100) not null,logintype varchar(20) default "",openid varchar(100) default "");';

$sql = $db->query($sql);

echo "数据表创建完毕";
?>