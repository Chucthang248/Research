<?php
echo "Bắt đầu script index.php\n";

require_once 'functions.php';
require_once 'functions.php'; // Cố tình require_once lại lần nữa
require_once 'functions.php'; // Và lần nữa

sayHello(); 

// => nếu không có function sayHello sẽ báo lỗi Fartal ERRROR và dừng thực thi toàn bộ
// => nếu trong file functions.php có bị lỗi biến sẽ báo lỗi Warning nhưng tiếp tục thực thi
echo "Kết thúc script index.php\n";
?>