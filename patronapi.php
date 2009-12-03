<?
/**
* This is a set of functions that allow access to the III Patron API
* This file is released under the GNU Public License
* @package PatronAPI
* @Author John Blyberg
*/


/**
* Change this to your PatronAPI server
*/
define("APISERVER", "http://your.iii.server.org:4500");


// Nothing below here needs to be configured

/**
* Returns patron data from the API in an easy-to-use array
* @param string $id Can be either a barcode number or a pnum, the function can tell which
* @return array 
*/
function get_patronapi_data($id) {

	if (strlen($id) < 14) {	$id = ".p" . $id; }
	$apiurl = APISERVER . "/PATRONAPI/$id/dump";

	$api_contents = get_api_contents($apiurl);

	$api_array_lines = explode("\n", $api_contents);
	while (strlen($api_data[PBARCODE]) != 14 && !$api_data[ERRNUM]) {
		foreach ($api_array_lines as $api_line) {
			$api_line = str_replace("p=", "peq", $api_line);
			$api_line_arr = explode("=", $api_line);
			$regex_match = array("/\[(.*?)\]/","/\s/","/#/");
			$regex_replace = array('','','NUM');
			$key = trim(preg_replace($regex_match, $regex_replace, $api_line_arr[0]));
			$api_data[$key] = trim($api_line_arr[1]);
		}
	}
	return $api_data;
}

/**
* Checks tha validity of an id/pin combo
* @param string $id Can be either a barcode number or a pnum, the function can tell which
* @param string $pin The password/pin to use with $id
* @return array
*/
function check_validation($id, $pin) {

	$pin = urlencode($pin);
	if (strlen($id) < 14) { $id = ".p" . $id; }
	$apiurl = APISERVER . "/PATRONAPI/$id/$pin/pintest";

	$api_contents = get_api_contents($apiurl);

	$api_array_lines = explode("\n", $api_contents);
	foreach ($api_array_lines as $api_line) {
		$api_line_arr = explode("=", $api_line);
		$api_data[$api_line_arr[0]] = $api_line_arr[1];
	}

	return $api_data;
}

/**
* An internal function to grab the API XML
* @param string $apiurl The formulated url to the patron API record
* @return string
*/
function get_api_contents($apiurl) {
	$api_contents = file_get_contents($apiurl);
	$api_contents = trim(strip_tags($api_contents));
	return $api_contents;
}

?>
