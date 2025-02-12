module.exports = {
    development: {
      client: "mysql2",
      connection: {
        host: process.env.DB_HOST || "dbjwt",
        user: process.env.DB_USER || "nodeuser",
        password: process.env.DB_PASSWORD || "nodepassword",
        database: process.env.DB_NAME || "nodejwt"
      },
      seeds: {
        directory: './seeds/dev',
      },
    }
  };
  