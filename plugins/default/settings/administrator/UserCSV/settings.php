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
 echo ossn_plugin_view('output/url', array(
  		'href' => ossn_site_url().'action/users/to/cvs', 
		'action' => true,
		'class' => 'btn btn-primary',
		'text' => ossn_print('userscsv:generate'),
  ));