const knex = require("../config/db");

const saveRefreshToken = async (userId, refreshToken) => {
  return knex("tokens").insert({
    user_id: userId,
    refresh_token: refreshToken,
  });
};

const findRefreshToken = async (refreshToken) => {
  return knex("tokens").where({ refresh_token: refreshToken }).first();
};

const deleteRefreshToken = async (refreshToken) => {
  return knex("tokens").where({ refresh_token: refreshToken }).del();
};

module.exports = {
  saveRefreshToken,
  findRefreshToken,
  deleteRefreshToken,
};
