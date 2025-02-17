// middlewares/authMiddleware.js
const jwt = require('jsonwebtoken');
const tokenModel = require("../models/tokenModel");
const logger = require("../helpers/logger");

exports.authenticateToken = async (req, res, next) => {
  const token = req.headers.authorization?.split(" ")[1];
  if (!token) return res.status(401).json({ message: "Unauthorized" });

  try {
    // Kiểm tra token có bị thu hồi không
    const tokenData = await tokenModel.findTokenPair(token);
    if (!tokenData) return res.status(403).json({ message: "Token không hợp lệ "});
    if (tokenData.revoke) return res.status(403).json({ message: "Token đã bị thu hồi" });
   
    // Giải mã và xác thực token
    jwt.verify(token, process.env.SECRET_KEY, (err, user) => {
      console.log(err);
      if (err) return res.status(403).json({ message: "Token không hợp lệ" });
      req.user = user;
      next();
    });
  } catch (err) {
      console.log(err);
    res.status(500).json({ message: "Lỗi hệ thống" });
  }
};