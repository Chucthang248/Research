<?php 
require_once 'LogStorage.php';

class CloudStorage implements LogStorage{
    
    public $config;
    /**
     * Ghi log lên dịch vụ cloud (giả lập)
     * 
     * @param array $config Mảng chứa thông tin cấu hình và nội dung log
     *                     - 'content': Nội dung log cần ghi
     *                     - 'log_level': Mức độ log (debug, info, warn, error)
     *                     - 'path': (tùy chọn) Đường dẫn cloud nơi lưu log
     *                     - 'fileName': (tùy chọn) Tên file trên cloud
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function write($content, $level)
    {
        
    }
}