const  {orgAndProject}  = require('../helpers/open-ai');

exports.renderHomePage = (req, res) => {
    // const openaiClient = orgAndProject();
   
    res.render('index', { title: 'Home Page', messages: 'TESST ' });
};
  
