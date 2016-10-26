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
$users = $users->getSiteUsers(array(
				'params' => array("first_name", "last_name", "email"),
				'page_limit' => false,
		  ));

foreach($users as $item){
	$results[] = (array)$item;
}

$fileName = "user-list-".date("d-m-Y").".csv";
 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
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

// 4. loop again and append member rows, setting matching keys to corresponding values 
$row = 0;
foreach ( $results as $data ) {
	$row++;
	foreach ( $keys as $key ) {
		$records[$row][$key] = $data[$key];
	}
}

foreach ( $records as $data ) {
    fputcsv($fh, $data);
}
fclose($fh);
exit;
