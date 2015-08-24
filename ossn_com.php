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
define('__USERCVS__', ossn_route()->com . 'UserCSV/');
/**
 * Initialize Component
 *
 * @return void
 */
function users_cvs_init() {
 	ossn_register_com_panel('UserCSV', 'settings');
	if(ossn_isLoggedin()) {
				ossn_register_action('users/to/cvs', __USERCVS__ . 'actions/generate.php');		
	}
}
/**
 * Array to csv
 *
 * See the original source: git@gist.github.com:4274500.git
 */
function array2csv($array, &$title, &$data) {
    foreach($array as $key => $value) {      
        if(is_array($value)) {
            $title .= $key . ",";
            $data .= "" . ",";
            array2csv($value, $title, $data);
        } else {
            $title .= $key . ",";
            $data .= '"' . $value . '",';
        }
    }
}

ossn_register_callback('ossn', 'init', 'users_cvs_init');
