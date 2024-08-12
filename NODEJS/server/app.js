const express = require('express');
const path = require('path');
const homeController = require('./controllers/homeController');

const app = express();
const PORT = process.env.PORT || 3000;

console.log('==================================')
console.log(path.join(__dirname, 'views'))
// Set view engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Routes
app.get('/', homeController.renderHomePage);

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
