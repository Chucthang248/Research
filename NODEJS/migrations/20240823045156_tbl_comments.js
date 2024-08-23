exports.up = function(knex) {
    return knex.schema.createTable('comments', (table) => {
      table.increments('id').primary();
      table.integer('post_id').unsigned().notNullable().references('id').inTable('posts').onDelete('CASCADE');
      table.integer('user_id').unsigned().notNullable().references('id').inTable('users').onDelete('CASCADE');
      table.text('comment').notNullable();
      table.timestamps(true, true);
    });
  };
  
  exports.down = function(knex) {
    return knex.schema.dropTable('comments');
  };
  