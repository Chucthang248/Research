module.exports = {
    REGISTER_SUCCESS: {
        status: 200,
        message: 'Đăng ký thành công',
    },
    LOGIN_SUCCESS: {
        status: 200,
        message: 'Đăng nhập thành công',
    },
    REGISTER_FAILED_EMAIL: {
        status: 400,
        message: 'Email đã tồn tại',
    },
    LOGIN_FAILED_EMAIL: {
        status: 402,
        message: 'Email không tồn tại',
    },
    LOGIN_FAILED: {
        status: 401,
        message: 'Đăng nhập thất bại. Email hoặc mật khẩu không chính xác.',
    },
    USER_CREATED: {
        status: 201,
        message: 'Người dùng đã được tạo thành công',
    },
    USER_NOT_FOUND: {
        status: 404,
        message: 'Người dùng không tồn tại',
    },
    USER_UPDATED: {
        status: 200,
        message: 'Thông tin người dùng đã được cập nhật thành công',
    },
    USER_DELETED: {
        status: 200,
        message: 'Người dùng đã bị xóa thành công',
    },
    INTERNAL_SERVER_ERROR: {
        status: 500,
        message: 'Lỗi server nội bộ',
    },
};
