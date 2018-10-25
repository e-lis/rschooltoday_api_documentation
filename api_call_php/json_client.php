<?php
# How to use rSchoolToday API WebService (REST) - download "rSchoolToday API-HowTo" documentation on http://api.rschooltoday.com/support/support_page
# Language	: PHP
# FileName	: json_client.php
# library	: jsonAPI using crul

# load jsonApi client
include ('lib/jsonAPI.php');

# initialize rSchoolToday API WebService URL
$url			= 'http://api.rSchoolToday.com/json_gen/json_page/index';

# initialize jsonApi client
$jsonAPI		= new jsonAPI;

# fill in rSchoolToday API WebService name, e.g : api_test_rest
#$service_name	= 'serviceName';
$service_name	= 'schedulesGetListByDateSchoolId';

# fill in Username & Password for authentication, e.g : account API Public Client Testing
$auth			= 'your_username:your_password';

# fill in the required parameters of API WebService.
# the parameters for each WebService is different,
# please refer to the WebService detail on API public view (http://api.rSchoolToday.com)
# example paramters of WebService 'api_test_rest'
$params	= array(
	'resource'		=> $service_name, # don't change this part
	'params'		=> array(
		'to_date'		=> '2018-10-10',
		'from_date'		=> '2018-10-20',
		'school_url'			=> 'http://www.fusionserverconference.org/g5-bin/client.cgi?G5genie=526&school_id=1'
	)
);

# call the WebService
$data_post 		= json_encode($params);
$data			= $jsonAPI->exec_curl($auth,$url,'POST',$data_post);
$status			= $jsonAPI->status;

# display the response
echo "HTTP Status : $status <br/>";
echo "<pre>";print_r($jsonAPI->jsonPre($data));

?>
