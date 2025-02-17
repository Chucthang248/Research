// routes/authRoutes.js
const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');
const { authenticateToken } = require('../middlewares/authMiddleware');

// Đăng ký
router.post("/register", authController.register);

// Đăng nhập
router.post('/login', authController.login);

// Đăng xuất (yêu cầu xác thực JWT)
router.post('/logout', authenticateToken, authController.logout);

// Lấy danh sách user (yêu cầu xác thực JWT)
router.get('/getall', authenticateToken, authController.getAllUser);

// refreshtoken
router.get('/refresh-token', authenticateToken, authController.refreshToken);

module.exports = router;
