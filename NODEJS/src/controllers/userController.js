const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const userModel = require('../models/userModel');
const tokenModel = require('../models/tokenModel');
const responseHelper = require('../helpers/responseHelpers');
const userResponse = require('../const/response/users');

require('dotenv').config();

const secretKey = process.env.SECRET_KEY;

// Tạo access token và refresh token
const generateTokens = (user) => {
    const accessToken = jwt.sign({ id: user.id, username: user.username }, secretKey, { expiresIn: '15m' });
    const refreshToken = jwt.sign({ id: user.id, username: user.username }, secretKey, { expiresIn: '7d' });
    return { accessToken, refreshToken };
};

// API Đăng ký
exports.register = async (req, res) => {
    const { username, email, password } = req.body;

    try {
        // Kiểm tra người dùng đã tồn tại
        const existingUser = await userModel.findUserByEmail(email);
        if (existingUser) {
            return responseHelper.sendResponse(res, userResponse.REGISTER_FAILED_EMAIL.status, userResponse.REGISTER_FAILED_EMAIL.message);
        }

        // Mã hóa mật khẩu
        const hashedPassword = await bcrypt.hash(password, 10);

        // Tạo người dùng mới
        const newUser = { username, email, password: hashedPassword };
        const userId = await userModel.createUser(newUser);

        // Tạo và lưu refresh token
        const tokens = generateTokens({ id: userId, username });
        await tokenModel.saveRefreshToken(userId, tokens.refreshToken);

        responseHelper.sendResponse(res, userResponse.REGISTER_SUCCESS.status, userResponse.REGISTER_SUCCESS.message);
    } catch (error) {
        responseHelper.sendResponse(res, userResponse.INTERNAL_SERVER_ERROR.status, userResponse.INTERNAL_SERVER_ERROR.message);
    }
};

// API Đăng nhập
exports.login = async (req, res) => {
    const { email, password } = req.body;

    try {
        const user = await userModel.findUserByEmail(email);
        if (!user) {
            return responseHelper.sendResponse(res, userResponse.LOGIN_FAILED_EMAIL.status, userResponse.LOGIN_FAILED_EMAIL.message);
        }

        // Kiểm tra mật khẩu
        const validPassword = await bcrypt.compare(password, user.password);
        if (!validPassword) {
            return res.status(400).json({ status: 400, message: 'Mật khẩu không chính xác' });
        }

        // Tạo và lưu refresh token
        const tokens = generateTokens(user);
        await tokenModel.saveRefreshToken(user.id, tokens.refreshToken);

        return responseHelper.sendResponse(res, userResponse.LOGIN_SUCCESS.status, userResponse.LOGIN_SUCCESS.message, tokens);
    } catch (error) {
        res.status(500).json({ status: 500, message: error.message });
    }
};

// API Làm mới token (dùng refresh token để lấy access token mới)
exports.refreshToken = async (req, res) => {
    const { refreshToken } = req.body;

    if (!refreshToken) {
        return res.status(403).json({ status: 403, message: 'Refresh token không được cung cấp' });
    }

    try {
        const existingToken = await tokenModel.findRefreshToken(refreshToken);
        if (!existingToken) {
            return res.status(403).json({ status: 403, message: 'Refresh token không hợp lệ' });
        }

        jwt.verify(refreshToken, secretKey, async (err, user) => {
            if (err) {
                return res.status(403).json({ status: 403, message: 'Refresh token đã hết hạn' });
            }

            const tokens = generateTokens(user);

            // Cập nhật refresh token trong cơ sở dữ liệu
            await tokenModel.deleteRefreshToken(refreshToken);
            await tokenModel.saveRefreshToken(user.id, tokens.refreshToken);

            res.status(200).json({ status: 200, message: 'Token được làm mới thành công', tokens });
        });
    } catch (error) {
        res.status(500).json({ status: 500, message: 'Lỗi server' });
    }
};
// API CRUD cho người dùng
exports.getUsers = async (req, res) => {
    try {
        const users = await userModel.getUsers();
        res.status(200).json({ status: 200, data: users });
    } catch (error) {
        res.status(500).json({ status: 500, message: error.message });
    }
};

// Cập nhật người dùng
exports.updateUser = async (req, res) => {
    const { id } = req.params;
    const { username, email, password } = req.body;

    try {
        const hashedPassword = await bcrypt.hash(password, 10);
        await userModel.updateUser(id, { username, email, password: hashedPassword });
        res.status(200).json({ status: 200, message: 'Cập nhật thành công' });
    } catch (error) {
        res.status(500).json({ status: 500, message: 'Lỗi server' });
    }
};

// Xóa người dùng
exports.deleteUser = async (req, res) => {
    const { id } = req.params;

    try {
        await userModel.deleteUser(id);
        res.status(200).json({ status: 200, message: 'Xóa thành công' });
    } catch (error) {
        res.status(500).json({ status: 500, message: 'Lỗi server' });
    }
};
