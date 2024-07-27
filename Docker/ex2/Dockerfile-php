# Sử dụng image PHP chính thức
FROM php:8.1-cli

# Tạo thư mục làm việc
WORKDIR /usr/src/myapp

# Sao chép mã nguồn vào trong container
COPY . .

# Thiết lập lệnh mặc định để chạy khi container khởi động
CMD [ "php", "./index.php" ]
