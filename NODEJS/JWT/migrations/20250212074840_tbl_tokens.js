/**
 * @param { import("knex").Knex } knex
 * @returns { Promise<void> }
 */
exports.up = function (knex) {
    return knex.schema.createTable("tbl_token", function (table) {
      table.increments("id").primary();
      table.integer("user_id").unsigned().references("id").inTable("users").onDelete("CASCADE");
      table.string("access_token").notNullable();
      table.string("refresh_token").notNullable();
      table.boolean("revoke").defaultTo(false); // Nếu true => token bị thu hồi
      table.timestamp("created_at").defaultTo(knex.fn.now());
      table.timestamp("expires_at").notNullable(); // Lưu thời gian hết hạn của access token
    });
};
  
exports.down = function (knex) {
    return knex.schema.dropTable("tbl_token");
};
