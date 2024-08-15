const  {orgAndProject}  = require('../helpers/open-ai');

exports.renderHomePage = (req, res) => {
    const openaiClient = orgAndProject();
    console.log("=============openaiClient===============");
    console.log(openaiClient)
    res.render('index', { title: 'Home Page', messages: 'DONEE' });
};
  
