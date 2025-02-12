// models/userModel.js
const knexConfig = require('../knexfile').development;
const knex = require('knex')(knexConfig);
const bcrypt = require('bcrypt');

exports.findUserByUsernameOrEmail = async (username, email) => {
  return await knex("users").where({ username }).orWhere({ email }).first();
};

exports.createUser = async ({ username, email, password }) => {
  const hashedPassword = await bcrypt.hash(password, 10);
  return await knex("users").insert({
    username,
    email,
    password: hashedPassword,
  });
};

exports.findUserByUsername = async (username) => {
  return await knex('users').where({ username }).first();
};

exports.updateRefreshToken = async (userId, refreshToken) => {
  return await knex('users').where({ id: userId }).update({ refresh_token: refreshToken });
};

exports.getAllUsers = async () => {
  return await knex('users').select('id', 'username');
};
