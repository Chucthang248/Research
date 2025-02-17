const faker = require('@faker-js/faker');
exports.seed = async function(knex) {
  // Xóa toàn bộ dữ liệu hiện tại
  await knex('posts').del();

  const posts = [];
  for (let i = 1; i <= 1000000; i++) {
    posts.push({
      user_id: Math.floor(Math.random() * 1000000) + 1,
      title: faker.lorem.sentence(),
      content: faker.lorem.paragraph(),
    });
  }

  await knex('posts').insert(posts);
};
