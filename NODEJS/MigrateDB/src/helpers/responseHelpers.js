module.exports = {
    sendResponse: (res, statusCode, message, data = null) => {
      return res.status(statusCode).json({
        status: statusCode,
        message,
        data,
      });
    },
  };
  