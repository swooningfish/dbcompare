<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$global_db_config = array(
 		'host'		=> 'localhost',		// The servers ip address or hostname
 		'user'		=> 'admin',			// The servers database username (strongly advise against using root)
 		'password'	=> 'password',		// The servers database password

 		'exclude_databaes' => array(	// Any databases you wish to exclude
			'mysql',
			'information_schema',
		),

		'use_includes' => 0,			// Set to 1 to only show the includes database
										// Set to 0 to all databases except thoese specified in the exclude_databaes array.

		'include_databaes' => array(	// Any databases you only show (need the use_includes set to 1
			'db-test_compare1',
			'db-test_compare2',
		)

);
?>