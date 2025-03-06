<?php
require_once 'LogStorage.php';

class FileStorage implements LogStorage{

    public $config;
    /**
     * Ghi log lên dịch vụ cloud (giả lập)
     * 
     * @param array $config Mảng chứa thông tin cấu hình và nội dung log
     *                     - 'path': (tùy chọn) Đường dẫn cloud nơi lưu log
     *                     - 'fileName': (tùy chọn) Tên file
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function write($content, $level)
    {
       // Đặt giá trị mặc định nếu không tồn tại trong config
        $path = isset($this->config['path']) ? $this->config['path'] : 'logs/'. $level;
        $fileName = isset($this->config['fileName']) ? $this->config['fileName'] : 'app.log';
        
        // Đảm bảo đường dẫn không có dấu / ở cuối
        $path = rtrim($path, '/');
        
        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($path) && !mkdir($path, 0755, true)) {
            throw new Exception("Không thể tạo thư mục log: $path");
        }
        
        // Tạo đường dẫn đầy đủ đến file
        $fullPath = $path . '/' . $fileName;
        
        // Tạo nội dung log
        $logEntry = date('Y-m-d H:i:s') . " [{$level}] " . $content . PHP_EOL;
        
        // Ghi log vào file
        if (file_put_contents($fullPath, $logEntry, FILE_APPEND) === false) {
            throw new Exception("Không thể ghi log vào file: $fullPath");
        }
    }
}