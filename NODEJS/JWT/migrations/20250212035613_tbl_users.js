exports.up = function(knex) {
    return knex.schema.createTable('users', function(table) {
        table.increments('id').primary();
        table.string('username').notNullable().unique();
        table.string('email').notNullable().unique();
        table.string('password').notNullable();
        table.string('refresh_token').nullable();
        table.timestamps(true, true);
    });
  };
  
exports.down = function(knex) {
    return knex.schema.dropTable('users');
};
  