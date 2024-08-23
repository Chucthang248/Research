const faker = require('@faker-js/faker');

exports.seed = async function(knex) {
  // Xóa toàn bộ dữ liệu hiện tại
  await knex('comments').del();

  const comments = [];
  for (let i = 1; i <= 1000000; i++) {
    comments.push({
      post_id: Math.floor(Math.random() * 1000000) + 1,
      user_id: Math.floor(Math.random() * 1000000) + 1,
      comment: faker.lorem.sentence(),
    });
  }

  await knex('comments').insert(comments);
};
