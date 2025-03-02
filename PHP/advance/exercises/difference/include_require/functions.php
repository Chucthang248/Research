<?php
echo "File functions.php đang được nhúng.\n";
// echo $test;
if (!function_exists('sayHello')) {
    echo "nhúng function sayHello \n";
    // function sayHello() {
    //     echo "Xin chào từ functions.php!\n";
    // }
    
} else {
    echo "Hàm sayHello đã được định nghĩa trước đó!\n";
}


?>