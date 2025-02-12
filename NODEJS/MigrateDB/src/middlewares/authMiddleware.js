const jwt = require('jsonwebtoken');
require('dotenv').config();

const secretKey = process.env.SECRET_KEY;

const authenticateToken = (req, res, next) => {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1]; // Lấy token từ header

  if (!token) return res.status(401).json({ status: 401, message: 'Token không được cung cấp' });

  jwt.verify(token, secretKey, (err, user) => {
    if (err) return res.status(403).json({ status: 403, message: 'Token không hợp lệ hoặc đã hết hạn' });

    req.user = user; // Gán thông tin người dùng vào req
    next();
  });
};

module.exports = authenticateToken;
