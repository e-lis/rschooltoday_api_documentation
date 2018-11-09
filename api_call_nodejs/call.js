
//API URL End Point 
var api_url = 'https://api.rschooltoday.com/json_gen/json_page/index/';
var user = 'your username';
var pwd = 'your password';
//we need request library 
var request = require('request'),
    options = {
        uri: api_url,
        json: true,
        auth: 
            {
                'user': user,
                'pass': pwd
            },
        method: 'POST',
        headers: {
            "content-type":"application/json"
        },
        json:
	//json format is vary, the format based on the web service. 
	//for example : the request format of levelGetList as follows:
            {
                resource:"levelGetList",
                params: { 
                    "school_url" : "the AS URL"
                }
            },
        pathname: '/'
    };

request(options, function (err, resp, body) {
    console.log(body);
});

