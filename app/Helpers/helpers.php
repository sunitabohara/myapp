<?php
/**
 * Collection of US states lists
 * @return array
 */
function us_states(){
	return [
		'' 	 => 'Select One',
	    'AL' => 'Alabama',
	    'AK' => 'Alaska',
	    'AZ' => 'Arizona',
	    'AR' => 'Arkansas',
	    'CA' => 'California',
	    'CO' => 'Colorado',
	    'CT' => 'Connecticut',
	    'DE' => 'Delaware',
	    'DC' => 'District of Columbia',
	    'FL' => 'Florida',
	    'GA' => 'Georgia',
	    'HI' => 'Hawaii',
	    'ID' => 'Idaho',
	    'IL' => 'Illinois',
	    'IN' => 'Indiana',
	    'IA' => 'Iowa',
	    'KS' => 'Kansas',
	    'KY' => 'Kentucky',
	    'LA' => 'Louisiana',
	    'ME' => 'Maine',
	    'MD' => 'Maryland',
	    'MA' => 'Massachusetts',
	    'MI' => 'Michigan',
	    'MN' => 'Minnesota',
	    'MS' => 'Mississippi',
	    'MO' => 'Missouri',
	    'MT' => 'Montana',
	    'NE' => 'Nebraska',
	    'NV' => 'Nevada',
	    'NH' => 'New Hampshire',
	    'NJ' => 'New Jersey',
	    'NM' => 'New Mexico',
	    'NY' => 'New York',
	    'NC' => 'North Carolina',
	    'ND' => 'North Dakota',
	    'OH' => 'Ohio',
	    'OK' => 'Oklahoma',
	    'OR' => 'Oregon',
	    'PA' => 'Pennsylvania',
	    'RI' => 'Rhode Island',
	    'SC' => 'South Carolina',
	    'SD' => 'South Dakota',
	    'TN' => 'Tennessee',
	    'TX' => 'Texas',
	    'UT' => 'Utah',
	    'VT' => 'Vermont',
	    'VA' => 'Virginia',
	    'WA' => 'Washington',
	    'WV' => 'West Virginia',
	    'WI' => 'Wisconsin',
	    'WY' => 'Wyoming',
	];
}

function USTimeZones(){
	return [
		'' 	 => 'Select One',
	  	'America/New_York'=>'EDT',
	  	'America/Chicago'=>'CDT',
	  	'America/Boise'=>'MDT',
	  	'America/Los_Angeles'=>'PDT'
	]; 
}

/**
 * Create folder according to entity name with naming by ID
 * @param  string $entity_name name of the parent folder like users, frs
 * @param  [type] $entity_id   name of the folder
 * @return boolean              
 */
function setupFolderFromId($entity_name, $entity_id){
	$base_path = getFullFolderDirPathFromId($entity_name, $entity_id);

	// Profile pics directory
	$profile_pic_path 		= "$base_path/profile/";
	$profile_thumb_path 	= "$base_path/profile/thumb";
	$pics_path 				= "$base_path/pics";

	if (!File::isDirectory($profile_pic_path)){
		File::makeDirectory($profile_pic_path, 0777, true);
	}
	if (!File::isDirectory($profile_thumb_path)){
		File::makeDirectory($profile_thumb_path, 0777, true);
	}

	if (!File::isDirectory($pics_path)){
		File::makeDirectory($pics_path, 0777, true);
	}
	return false;
}

/**
 * get absolute path for the given entity with id
 * @param  string $entity_name
 * @param  integer $entity_id
 * @return string
 */
function getFullFolderDirPathFromId($entity_name, $entity_id, $with_storage = true) {
	$tmp_arr = str_split( getZeroPaddedNumber($entity_id), 3 );
	$path 	 = $with_storage ? storage_path('app/' . $entity_name . '/' . implode('/', $tmp_arr)) : 'app/' . $entity_name . '/' . implode('/', $tmp_arr);
	// $path 	 = public_path('uploads/' . $entity_name . '/' . implode('/', $tmp_arr));
	return $path;
}

/**
 * breakdown of numbers
 * @param  integer  $num
 * @param  integer $size
 * @return string       
 */
function getZeroPaddedNumber($num, $size=12) {
	$format = '%1$0' . $size . 'd';  // $size digit number with preceding 0s
	return sprintf( $format, $num );
}

/**
 * page pagination number
 * @return int
 */
function per_page() {
	return 20;
}

/**
* returns currenry as a formatted string
* @param integer $amount
* @param string $symbol currency symbol
* @return string
*/
function currency_format($amount, $symbol = '$'){
	// if($amount){
		return $symbol . number_format($amount != '' ? $amount : 0, 2, '.', '');
	// }
	// return false;
}

/**
 * return date or time as formatted according to Timezone
 * @param  date $date     
 * @param  string $datetime 
 * @return mixed
 */
function convert_timezone($date, $datetime = 'both'){
	$static_date = $date;
	if($static_date == '')
		return '';
	$src_tz = new DateTimeZone('UTC');
	$dest_tz = new DateTimeZone('EST');

	$dt = new DateTime($static_date, $src_tz);
	$dt->setTimeZone($dest_tz);

	$format = $datetime == 'both' ? 'm/d/Y g:i A' : ($datetime == 'time' ? 'g:i A ' : 'm/d/Y');
	
	return $dt->format($format);
}

/**
 * Save SMS picture recieved from twilio request
 * @param  string $media     full URL of image
 * @param  string $mediatype extension
 * @return string $name
 */
function smsPictureUpload($media, $mediatype){
	if($mediatype == 'image/png')
		$ext = 'png';
	else if($mediatype == 'image/gif')
		$ext = 'gif';
	else
		$ext = 'jpg';

	$path_parts = pathinfo($media);

	$filename 	 = $path_parts['filename']; //4320885_orig
	$picture 	 = $filename . '.' . $ext;
	$picture_url = $media;
	$st_path 	 = storage_path("sms-uploads/" . $picture);

	//get file content from url
	$file = file_get_contents($media);
	
	//Store in the filesystem.
	/*$fp = fopen("storage/sms-uploads/" . $picture, "w");
	fwrite($fp, $file);
	fclose($fp);*/
	 $save = file_put_contents($st_path, $file);
	// if($save)
		resizePicture($media, $filename, $ext);

	return $filename;
}

/**
 * resize the picture
 * @param  string $picurl
 * @param  string $picname
 * @param  string $picext
 * @return Response
 */
function resizePicture($picurl, $picname, $picext)
{
	$quality = 100;
	$img = file_get_contents($picurl);	

	$im 	= imagecreatefromstring($img);
	$width 	= imagesx($im);
	$height = imagesy($im);

	$newwidth = '120';
	$newheight = '120';

	$thumb = imagecreatetruecolor($newwidth, $newheight);

	imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	$output = storage_path("sms-uploads/" . $picname . '_thumb.' . $picext);
	switch ($picext) {
		case 'png':
			$quality = 9 - (int)((0.9*$quality)/10.0);
    		imagepng($thumb, $output, $quality);
			break;
		case 'gif':
			imagegif($thumb, $output);
			break;
		default:
			imagejpeg($thumb, $output); //save image as jpg
			break;
	}		

	imagedestroy($thumb); 

	imagedestroy($im);
}

/**
 * this will format the phone number
 * 9841452230 to (984) 145-2230
 *
 * @param $string
 * @return mixed
 */
function formatPhone($string) {
    $number = trim(preg_replace('#[^0-9]#s', '', $string));

    $length = strlen($number);
    if($length == 7) {
        $regex = '/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/';
        $replace = '$1-$2';
    }
	elseif($length == 10) {
        $regex = '/([0-9]{3})([0-9]{3})([0-9]{4})/';
        $replace = '($1) $2-$3';
    }
    elseif($length == 11) {
        $regex = '/([0-9]{1})([0-9]{3})([0-9]{3})([0-9]{4})/';
        $replace = '($2) $3-$4';
    }

    $formatted = false;
    if(isset($regex))
        $formatted = preg_replace($regex, $replace, $number);

    return $formatted;
}

/**
 * this will plain the format phone
 *
 * @param $phone
 * @return mixed
 */
function plainPhone($phone){
	return preg_replace("/[^0-9]/", "", $phone);
}

/**
 * Find Date in a String
 *
 * @author   Etienne Tremel
 * @license  http://creativecommons.org/licenses/by/3.0/ CC by 3.0
 * @link     http://www.etiennetremel.net
 *
 * @param string	find_date( ' some text 01/01/2012 some text' ) or find_date( ' some text October 5th 86 some text' )
 * @return mixed	false if no date found else array: array( 'day' => 01, 'month' => 01, 'year' => 2012 )
 */
function find_date( $string ) {
	//Define month name:
	$month_names = array( 
		"january",
		"february",
		"march",
		"april",
		"may",
		"june",
		"july",
		"august",
		"september",
		"october",
		"november",
		"december"
	);
	$month_number=$month=$matches_year=$year=$matches_month_number=$matches_month_word=$matches_day_number="";
	
	//Match date: 01/01/2015
	preg_match("/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/", $string, $matches);

		echo "<pre>"; print_r($matches);
	if($matches){
	}

	//Match dates: 01/01/2012 or 30-12-11 or 1 2 1985
	preg_match( '/([0-9]?[0-9])[\.\-\/ ]?([0-1]?[0-9])[\.\-\/ ]?([0-9]{2,4})/', $string, $matches );
	if ( $matches ) {
		if ( $matches[1] )
			$day = $matches[1];
		if ( $matches[2] )
			$month = $matches[2];
		if ( $matches[3] )
			$year = $matches[3];
	}
	//Match month name:
	preg_match( '/(' . implode( '|', $month_names ) . ')/i', $string, $matches_month_word );
	if ( $matches_month_word ) {
		if ( $matches_month_word[1] )
			$month = array_search( strtolower( $matches_month_word[1] ),  $month_names ) + 1;
	}
	//Match 5th 1st day:
	preg_match( '/([0-9]?[0-9])(st|nd|th)/', $string, $matches_day );
	if ( $matches_day ) {
		if ( $matches_day[1] )
			$day = $matches_day[1];
	}
	//Match Year if not already setted:
	if ( empty( $year ) ) {
		preg_match( '/[0-9]{4}/', $string, $matches_year );
		if ( $matches_year[0] )
			$year = $matches_year[0];
	}
	if ( ! empty ( $day ) && ! empty ( $month ) && empty( $year ) ) {
		preg_match( '/[0-9]{2}/', $string, $matches_year );
		if ( $matches_year[0] )
			$year = $matches_year[0];
	}
	//Leading 0
	if ( 1 == strlen( $day ) )
		$day = '0' . $day;
	//Leading 0
	if ( 1 == strlen( $month ) )
		$month = '0' . $month;
	//Check year:
	if ( 2 == strlen( $year ) && $year > 20 )
		$year = '19' . $year;
	else if ( 2 == strlen( $year ) && $year < 20 )
		$year = '20' . $year;
	$date = array(
		'year' 	=> $year,
		'month' => $month,
		'day' 	=> $day
	);
	//Return false if nothing found:
	if ( empty( $year ) && empty( $month ) && empty( $day ) )
		return false;
	else
		return $date;
}

/**
 * Save image with thumb
 * @param  array  $inputs
 * @param  string $folder_path 
 * @param  array  $attrib
 * @return boolean
 */
function saveImageWithThumb($inputs, $folder_path, $attrib = array()){
	$name 	= isset($attrib['name']) ? $attrib['name'] : 'image';
	$ext 	= 'jpg'; //isset($attrib['ext']) ? $attrib['ext'] : 'jpg';
	$w 		= isset($attrib['resize_w']) ? $attrib['resize_w'] : 140;
	$h 		= isset($attrib['resize_h']) ? $attrib['resize_h'] : 140;
	$path 	= $folder_path;

	$filename = $name . '.' . $ext;
	//move the image with new filename
	$inputs->move($path, $filename);

	//image manipulation with intervention
	$image 	= Image::make($folder_path . $filename);

	// encode image to according to ext
    $image->encode($ext);
    // save original
    // $image->save($path, $filename);
    //resize
    $image->resize($w, $h);
    $image->resize( $w, $h, function( $constraint ) {
        $constraint->aspectRatio();
    });
    // save resized
    $image->save($path . "thumb/" . $name . '.' . $ext);
}
/**
 * write custom application error logs with date
 * @param  string $error
 * @return void
 */
function writeCustomAppErrorLogs($error){
	$content = "Created on " . date('m-d-Y H:i:s') . PHP_EOL;
	$content .= "------------------------------------------" . PHP_EOL;
	$content .= $error . PHP_EOL;
	$content .= "==========================================" . PHP_EOL;
	$content;
	if (\Storage::exists('custom-logs/error-logs.log')) {
		\Storage::prepend('custom-logs/error-logs.log', $content);
	}
	else{
		\Storage::put('custom-logs/error-logs.log', $content);	
	}
}

/**
 * Set active page
 *
 * @param string $uri
 * @return string
 */
function set_active($uri)
{
	return Request::is($uri) ? 'active' : '';
}

/**
 * check if a date is in a given range
 *
 * @param $start
 * @param $end
 * @param $date
 * @return boolean
 */
function check_date_in_range($start, $end, $date)
{
	// Convert to timestamp
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$user_ts = strtotime($date);

	// Check that date is between start & end
	return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
}

/**
 * Display numbers with ordinal suffix
 *
 * @param $number
 * @return string
 */
function ordinal($number) {
	$ends = array('th','st','nd','rd','th','th','th','th','th','th');
	if ((($number % 100) >= 11) && (($number%100) <= 13))
		return $number. '<sup>th</sup>';
	else
		return $number. '<sup>' . $ends[$number % 10] . '</sup>';
}

/**
 * format the date according to given format
 *
 * @param $date
 * @param string $format
 * @return mixed
 */
function format_date($date, $format = 'm/d/Y'){
	return \Carbon::parse($date)->format($format);
}

/**
 * format the date according to given format
 *
 * @param $date
 * @param string $format
 * @return mixed
 */
function change_format_date($date, $format = 'm/d/Y'){
	/*return \Carbon::parse(strtotime($date))->format($format);*/
	return date($format, strtotime($date));
}

function get_image($id, $pictureName, $entity, $thumb = false){
	$folder_path	= getFullFolderDirPathFromId($entity, $id);
	$img_full_path 	= $folder_path . '/profile/';
	$img_thum_path 	= $folder_path . '/profile/thumb/';
	if (\File::isFile($img_full_path . $pictureName) || \File::isFile($img_thum_path . $pictureName)){
		$pic_path = $thumb ? route('images', [$entity, $id, $pictureName, 'thumb']) : route('images', [$entity, $id, $pictureName]);
	}
	else{
		$pic_path = asset('shared/images/no-image.png');
	}
	return $pic_path;
}

/**
 * detect app environment
 *
 * @return string
 */
function detect_env(){
	return app()->detectEnvironment(function()
	{
		return getenv('APP_ENV') ?: 'production';
	});
}

/**
 * Convert a date(time) string to another format or timezone
 *
 * DateTime::createFromFormat requires PHP >= 5.3
 *
 * @param string $dt
 * @param string $tz1
 * @param string $df1
 * @param string $tz2
 * @param string $df2
 * @return string
 */
function convertUTCToTz($dt, $tz1, $df1, $tz2, $df2){
	$res = '';
	if(!in_array($tz1, timezone_identifiers_list())) { // check source timezone
		trigger_error(__FUNCTION__ . ': Invalid source timezone ' . $tz1, E_USER_ERROR);
	} elseif(!in_array($tz2, timezone_identifiers_list())) { // check destination timezone
		trigger_error(__FUNCTION__ . ': Invalid destination timezone ' . $tz2, E_USER_ERROR);
	} else {
		// create DateTime object
		$d = DateTime::createFromFormat($df1, $dt, new DateTimeZone($tz1));
		// check source datetime
		if($d && DateTime::getLastErrors()["warning_count"] == 0 && DateTime::getLastErrors()["error_count"] == 0) {
			// convert timezone
			$d->setTimeZone(new DateTimeZone($tz2));
			// convert dateformat
			$res = $d->format($df2);
		} else {
			trigger_error(__FUNCTION__ . ': Invalid source datetime ' . $dt . ', ' . $df1, E_USER_ERROR);
		}
	}
	return $res;
}

/**
 * Convert the time in GMT timestamp into given time zone timestamp
 * $gmttime should be in timestamp format like 'Y-m-d 09:48:00.000'
 * $timezoneRequired sholud be a string like 'America/Chicago' not 'CST'
 *
 * @param $gmttime
 * @param $timezoneRequired
 * @param $format
 * @return string
 */
function ConvertGMTToLocalTimezone($gmttime, $timezoneRequired, $format = 'Y-m-d H:i:s')
{
	$system_timezone = date_default_timezone_get();

	date_default_timezone_set("GMT");
	$gmt = date($format);

	$local_timezone = $timezoneRequired;
	date_default_timezone_set($local_timezone);
	$local = date($format);

	date_default_timezone_set($system_timezone);
	$diff = (strtotime($local) - strtotime($gmt));

	$date = new DateTime($gmttime);
	$date->modify("+$diff seconds");
	$timestamp = $date->format($format);
	return $timestamp;
}

/**
 * detemine
 *
 * @param $number
 * @return string
 */
function checkGroupRange($number){
	if($number < 25){
		return array('10-25', 25);
	}
	elseif($number < 100){
		return array('26-100', 100);
	}
	elseif($number < 500){
		return array('101-500', 500);
	}
	else{
		return array('501-2000', 2000);
	}
}

/**
 * send CRM text OptIn method text message
 *
 * @param $data
 */
function regCrmTxt($data){
	$userId    	= \Config::get('twilio.crm_userid');
	$passwd  	= \Config::get('twilio.crm_password');

	$keyword 	= $data['keyword'];
	$to 		= plainPhone($data['to']);
	$firstname 	= isset($data['firstname']) ? $data['firstname'] : "";
	$lastname 	= isset($data['lastname']) ? $data['lastname'] : "";

	$postFields = "method=optincustomer&firstname={$firstname}&lastname={$lastname}&phone_number={$to}";
	$authString = $userId . ':'. $passwd . ':'. $keyword ;
	$centralUrl = "https://restapi.crmtext.com/smapi/rest" ;

	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $centralUrl );
	curl_setopt ( $ch, CURLOPT_FAILONERROR, 1 );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 6 );
	curl_setopt ( $ch, CURLOPT_POST, true );
	curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
	curl_setopt ( $ch, CURLOPT_USERPWD, $authString );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );

	try {
		$result = curl_exec ( $ch );
		curl_close($ch);
	}
	catch (Exception $e) {
		writeCustomAppErrorLogs($e->getMessage());
	}
}

function crmTextMessage($data){
	$userId    	= \Config::get('twilio.crm_userid');
	$passwd  	= \Config::get('twilio.crm_password');

	$message 	= $data['message'];
	$keyword 	= $data['keyword'];
	$to 		= plainPhone($data['phone']);

	$postFields = "method=sendsmsmsg&phone_number={$to}&message={$message}";
	$authString = $userId . ':'. $passwd . ':'. $keyword ;
	$centralUrl = "https://restapi.crmtext.com/smapi/rest" ;

	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $centralUrl );
	curl_setopt ( $ch, CURLOPT_FAILONERROR, 1 );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 6 );
	curl_setopt ( $ch, CURLOPT_POST, true );
	curl_setopt ( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
	curl_setopt ( $ch, CURLOPT_USERPWD, $authString );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postFields );

	try {
		$result = curl_exec ( $ch );
		curl_close($ch);
	}
	catch (Exception $e) {
		writeCustomAppErrorLogs($e->getMessage());
	}
}

/**
 * Delete element from multidimensional-array based on value
 *
 * @param $array
 * @param $key
 * @param $value
 * @return array
 */
function removeElementWithValue($array, $key, $value){
    $newArray = [];
    foreach($array as $subKey => $subArray){
        if($subArray->{$key} == $value){
            $newArray[][] = $array[$subKey];
            unset($array[$subKey]);
        }
    }
    $array = count($newArray) > 0 ? (array_merge($array, $newArray[0])) : $array;
    return $array;
}