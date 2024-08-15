const db = require('../config/db');

const getAllUsers = (callback) => {
  db.query('SELECT * FROM users', (err, results) => {
    if (err) {
      return callback(err, null);
    }
    callback(null, results);
  });
};

module.exports = { getAllUsers };
