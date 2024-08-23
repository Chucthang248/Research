const faker = require('@faker-js/faker');

exports.seed = async function(knex) {
  // Xóa toàn bộ dữ liệu hiện tại
  await knex('followers').del();

  const followers = [];
  for (let i = 1; i <= 1000000; i++) {
    followers.push({
      user_id: Math.floor(Math.random() * 1000000) + 1,
      follower_id: Math.floor(Math.random() * 1000000) + 1,
    });
  }

  await knex('followers').insert(followers);
};
