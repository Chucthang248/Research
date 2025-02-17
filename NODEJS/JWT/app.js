// app.js
require('dotenv').config();
const express = require('express');
const bodyParser = require('body-parser');
const authRoutes = require('./routes/authRoutes');


const app = express();

app.use(bodyParser.json());

// Gắn kết các route
app.use('/api/users', authRoutes);


console.log("DATABASE_URL:", process.env.DATABASE_URL || "Not found");
console.log("PORT:", process.env.PORT || "Not found");

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server đang chạy tại cổng ${PORT}`);
});
