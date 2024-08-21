const express = require('express');
const userRoutes = require('./src/routes/userRoutes');

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.json()); // Parse JSON

app.use('/api', userRoutes); // Đường dẫn chính cho API

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});