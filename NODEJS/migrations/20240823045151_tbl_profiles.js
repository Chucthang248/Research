exports.up = function(knex) {
    return knex.schema.createTable('profiles', (table) => {
      table.increments('id').primary();
      table.integer('user_id').unsigned().notNullable().references('id').inTable('users').onDelete('CASCADE');
      table.string('bio').notNullable();
      table.string('website');
      table.timestamps(true, true);
    });
  };
  
  exports.down = function(knex) {
    return knex.schema.dropTable('profiles');
  };
  