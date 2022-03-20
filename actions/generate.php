<?php
/**
 * Open Source Social Network
 *
 * @packageOpen Source Social Network
 * @author    Open Social Website Core Team <info@informatikon.com>
 * @copyright 2014 iNFORMATIKON TECHNOLOGIES
 * @license   General Public Licence http://www.opensource-socialnetwork.org/licence
 * @link      http://www.opensource-socialnetwork.org/licence
 */
$users = new OssnUser;
$params_to_export = array("first_name", "last_name", "email"); //for email just keep email and remove others.
$users = $users->searchUsers(array(
				'page_limit' => false,
));

foreach($users as $item){
	if($item instanceof OssnUser){	
		foreach($item as $key => $value){
			if(!isset($results[$item->guid])){
				$results[$item->guid] = new stdClass();	
			}
			if(in_array($key, $params_to_export)){
				$results[$item->guid]->{$key} = $value;	
			}
		}
		$results[$item->guid] = (array)$results[$item->guid];
	}
}
$fileName = "user-list-".date("d-m-Y").".csv";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header('Content-type: text/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename={$fileName}");
header("Expires: 0");
header("Pragma: public");

$fh = @fopen( 'php://output', 'w' );

// 1. extract all keys
$keys = array();
foreach ( $results as $data ) {
	$keys = array_merge($keys, array_keys($data));
}

// 2. remove duplicate keys
$keys = array_unique($keys);
// 2a. for some reason I don't understand getUser() returns an empty Object named 'data' - remove it!
$keys = array_diff($keys, ['data']);

// 3. build up new array with record[0] using keys as csv file headline
$records = array();
foreach ( $keys as $key ) {
	$records[0][$key] = $key;
}

fprintf($fh, chr(0xEF).chr(0xBB).chr(0xBF));
// 4. loop again and append member rows, setting matching keys to corresponding values 
// write header row
fputcsv($fh, $records[0]);

foreach ( $results as $data ) {
	foreach ( $keys as $key ) {
		// don't exhaust mem with another mammoth array - just overwrite
		$records[0][$key] = $data[$key];
	}
	fputcsv($fh, $records[0]);
}

fclose($fh);
exit;
