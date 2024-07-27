const axios = require('axios');
const https = require('https');

function getjson(){
    let arr = [{name:"tien",age:24}];
    return JSON.stringify(arr)
}


exports.lambdaHandler = async (event, context) => {
    let getData = await axios.get('https://countriesnow.space/api/v0.1/countries/population/cities')
    try {
        response = {
            'data': getData.data.data[0].city,
        }
    } catch (err) {
        console.log(err);
        return err;
    }

    return response
};
