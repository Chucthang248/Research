// server/controllers/homeController.js

exports.renderHomePage = (req, res) => {
    res.render('index', { title: 'Home Page', message: 'Home Page' });
};
  