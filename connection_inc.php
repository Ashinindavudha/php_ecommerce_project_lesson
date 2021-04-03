<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "ecommerce_php");
define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT']. '/ecommerce_php/admin/');
define('SITE_PATH', 'http://127.0.0.1/ecommerce_php/admin/');

define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH. '/media/product/');
define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH. '/media/product/');

