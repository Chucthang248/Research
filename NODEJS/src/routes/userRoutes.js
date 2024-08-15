const express = require('express');
const router = express.Router();
const userController = require('../controllers/indexController');

router.get('/', userController.getUsers);

module.exports = router;
