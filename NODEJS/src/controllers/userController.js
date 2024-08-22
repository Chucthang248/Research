const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const userModel = require('../models/userModel');
const knex = require('../config/db');
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
      return res.status(400).json({ status: 400, message: 'Email đã tồn tại' });
    }

    // Mã hóa mật khẩu
    const hashedPassword = await bcrypt.hash(password, 10);

    // Tạo người dùng mới
    const newUser = { username, email, password: hashedPassword };
    await userModel.createUser(newUser);

    res.status(201).json({ status: 201, message: 'Đăng ký thành công' });
  } catch (error) {
    res.status(500).json({ status: 500, message: 'Lỗi server' });
  }
};

// API Đăng nhập
exports.login = async (req, res) => {
  const { email, password } = req.body;

  try {
    const user = await userModel.findUserByEmail(email);
    if (!user) {
      return res.status(400).json({ status: 400, message: 'Email không tồn tại' });
    }

    // Kiểm tra mật khẩu
    const validPassword = await bcrypt.compare(password, user.password);
    if (!validPassword) {
      return res.status(400).json({ status: 400, message: 'Mật khẩu không chính xác' });
    }

    const tokens = generateTokens(user);

    res.status(200).json({ status: 200, message: 'Đăng nhập thành công', tokens });
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
