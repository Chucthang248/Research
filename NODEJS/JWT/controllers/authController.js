// controllers/authController.js
const jwt = require('jsonwebtoken');
const bcrypt = require('bcrypt');
const userModel = require('../models/userModel');
const tokenModel = require("../models/tokenModel");
const logger = require("../helpers/logger");
const SECRET_KEY = 'your_secret_key';  // Nên đưa vào biến môi trường (env)

exports.register = async (req, res) => {
  try {
    const { username, email, password } = req.body;
    logger.info(`Đăng ký user: ${username}, email: ${email}`);

    // Kiểm tra xem username hoặc email đã tồn tại chưa
    const existingUser = await userModel.findUserByUsernameOrEmail(username, email);
    if (existingUser) {
      logger.warn("Username hoặc Email đã tồn tại");
      return res.status(400).json({ message: "Username hoặc Email đã tồn tại" });
    }

    // Tạo user mới
    const userId = await userModel.createUser({ username, email, password });

    res.status(201).json({ message: "Đăng ký thành công", userId });
  } catch (error) {
    logger.error(`Lỗi đăng ký: ${error.message}`);
    res.status(500).json({ message: "Lỗi server" });
  }
};

exports.login = async (req, res) => {
  try {
    const { username, password } = req.body;
    const user = await userModel.findUserByUsername(username);
    if (!user) return res.status(400).json({ message: "User không tồn tại" });

    const valid = await bcrypt.compare(password, user.password);
    if (!valid) return res.status(400).json({ message: "Mật khẩu không đúng" });

    // Tạo access token và refresh token
    const accessToken = jwt.sign({ id: user.id, username: user.username }, process.env.SECRET_KEY, { expiresIn: "15m" });
    const refreshToken = jwt.sign({ id: user.id, username: user.username }, process.env.SECRET_KEY, { expiresIn: "7d" });

    // Lưu token vào `tbl_token` mà không ảnh hưởng đến phiên đăng nhập khác
    await tokenModel.insertToken(user.id, accessToken, refreshToken);

    res.json({ accessToken, refreshToken });
  } catch (error) {
    logger.error(`Lỗi login: ${error.message}`);
    res.status(500).json({ message: "Lỗi hệ thống" });
  }
};

exports.logout = async (req, res) => {
  try {
    const token = req.headers.authorization?.split(" ")[1];
    if (!token) {
      return res.status(400).json({ message: "Thiếu token để logout" });
    }

    // Tìm cặp token liên quan
    const tokenData = await tokenModel.findTokenPair(token);
    if (!tokenData) return res.status(403).json({ message: "Token không hợp lệ" });

    // Thu hồi token (revoke cả cặp `accessToken` + `refreshToken`)
    await tokenModel.revokeTokenPair(token);

    res.json({ message: "Đăng xuất thành công" });
  } catch (err) {
    res.status(500).json({ message: "Lỗi hệ thống" });
  }
};

exports.refreshToken = async (req, res) => {
  try {
    const { refreshToken } = req.body;
    if (!refreshToken) return res.status(401).json({ message: "Thiếu refresh token" });

    // Tìm token theo `refreshToken`
    const tokenData = await tokenModel.findTokenPair(refreshToken);
    if (!tokenData || tokenData.revoke) {
      return res.status(403).json({ message: "Refresh token không hợp lệ hoặc đã bị thu hồi" });
    }

    // Tìm thông tin user từ DB
    const user = await userModel.findUserById(tokenData.user_id);
    if (!user) return res.status(403).json({ message: "User không tồn tại" });

    // Tạo access token mới
    const newAccessToken = jwt.sign({ id: user.id, username: user.username }, SECRET_KEY, { expiresIn: "15m" });

    // Thu hồi `refreshToken` cũ (xóa hoặc update `revoke: true`)
    await tokenModel.revokeTokenPair(refreshToken);

    // Tạo `refreshToken` mới để thay thế
    const newRefreshToken = jwt.sign({ id: user.id, username: user.username }, SECRET_KEY, { expiresIn: "7d" });

    // Lưu `refreshToken` mới vào DB
    await tokenModel.insertToken(user.id, newAccessToken, newRefreshToken);

    res.json({ accessToken: newAccessToken, refreshToken: newRefreshToken });
  } catch (err) {
    res.status(500).json({ message: "Lỗi hệ thống" });
  }
};

exports.getAllUser = async (req, res) => {
  try {
    const users = await userModel.getAllUsers();
    res.json(users);
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Lỗi hệ thống' });
  }
};
