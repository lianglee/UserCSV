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
				'params' => array("first_name", "last_name", "email")					
		  ));

foreach($users as $item){
	$results[] = (array)$item;
}

$fileName = "user-list-".date("d-y-m").".csv";
 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename={$fileName}");
header("Expires: 0");
header("Pragma: public");

$fh = @fopen( 'php://output', 'w' );

$headerDisplayed = false;

foreach ( $results as $data ) {
    if ( !$headerDisplayed ) {
        fputcsv($fh, array_keys($data));
        $headerDisplayed = true;
    }
 
    fputcsv($fh, $data);
}
fclose($fh);
exit;