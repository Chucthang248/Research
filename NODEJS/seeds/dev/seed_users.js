const faker = require('@faker-js/faker');

exports.seed = async function(knex) {
  // Xóa toàn bộ dữ liệu hiện tại
  await knex('users').del();

  const users = [];
  for (let i = 1; i <= 1000000; i++) {
    users.push({
      username: faker.internet.userName(),
      email: faker.internet.email(),
      password: faker.internet.password(), // Mã hóa mật khẩu khi thực tế triển khai
    });
  }

  await knex('users').insert(users);
};
