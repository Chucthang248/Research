/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function(knex) {
    return knex.schema
    .createTable('tbl_multiple_choice', function (table) {
      table.increments('id').unsigned();
      table.integer('category_id', 255);
      table.text('question').notNullable();
      table.text('answer').notNullable();
      table.datetime('created', { precision: 6 }).defaultTo(knex.fn.now(6));
    })
};

/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.down = function(knex) {
    return knex.schema.dropTable('tbl_multiple_choice');
};
