const { createLogger, format, transports } = require("winston");

const logger = createLogger({
  level: "info", // Cấp độ log: 'info', 'warn', 'error', 'debug'
  format: format.combine(
    format.timestamp({ format: "YYYY-MM-DD HH:mm:ss" }),
    format.printf(({ timestamp, level, message }) => `${timestamp} [${level.toUpperCase()}]: ${message}`)
  ),
  transports: [
    new transports.Console(), // Log ra terminal
    new transports.File({ filename: "logs/error.log", level: "error" }), // Lưu log lỗi vào file
    new transports.File({ filename: "logs/combined.log" }) // Lưu tất cả log vào file
  ],
});

module.exports = logger;
