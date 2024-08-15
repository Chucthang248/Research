require('dotenv').config();
const express = require('express');
const path = require('path');
const homeController = require('./src/controllers/homeController');

const app = express();
const PORT = 3000;

// Set view engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'src/views'));

// Routes
app.get('/', homeController.renderHomePage);

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
