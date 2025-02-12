// models/tokenModel.js
const knexConfig = require('../knexfile').development;
const knex = require('knex')(knexConfig);


// Thêm một cặp `accessToken` + `refreshToken` vào bảng `tbl_token`
exports.insertToken = async (userId, accessToken, refreshToken) => {
    return await knex("tbl_token").insert({
        user_id: userId,
        access_token: accessToken,
        refresh_token: refreshToken,
        revoke: false,
        expires_at: knex.raw("DATE_ADD(NOW(), INTERVAL 15 MINUTE)"),
    });
};

// Tìm token theo cặp `accessToken` + `refreshToken`
exports.findTokenPair = async (token) => {
    return await knex("tbl_token")
        .where("access_token", token)
        .orWhere("refresh_token", token)
        .first();
};

// Thu hồi token theo cặp (cùng 1 row)
exports.revokeTokenPair = async (token) => {
    return await knex("tbl_token")
        .where("access_token", token)
        .orWhere("refresh_token", token)
        .update({ revoke: true });
};