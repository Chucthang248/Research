const knex = require('../config/db');

const getUsers = async (id) => {
  return knex('users').select('*');
};

const createUser = async (userData) => {
  return knex('users').insert(userData);
};

const findUserByEmail = async (email) => {
  return knex('users').where({ email }).first();
};

const findUserByUsername = async (username) => {
  return knex('users').where({ username }).first();
};

const findUserById = async (id) => {
  return knex('users').where({ id }).first();
};

const updateUser = async (id, userData) => {
  return knex('users').where({ id }).update(userData);
};

const deleteUser = async (id) => {
  return knex('users').where({ id }).del();
};

module.exports = {
  createUser,
  findUserByEmail,
  findUserByUsername,
  findUserById,
  updateUser,
  deleteUser,
  getUsers
};
