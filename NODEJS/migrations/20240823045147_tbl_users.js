exports.up = function(knex) {
    return knex.schema.createTable('users', function(table) {
      table.increments('id').primary();
      table.string('username', 255).notNullable().unique();
      table.string('email', 255).notNullable().unique();
      table.string('password', 255).notNullable();
      table.timestamps(true, true);
    });
  };
  
exports.down = function(knex) {
    return knex.schema.dropTable('users');
};
  