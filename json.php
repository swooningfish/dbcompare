<?php

/**

 * Copyright (C) 2013, Greg Colley
 * Available under http://en.wikipedia.org/wiki/MIT_License
 *
 * @author Greg Colley
 */
require('config.php');

// Override the config settings for suppressing errors
error_reporting(E_ALL);
ini_set('display_errors', 0);

require('functions.php');
require_once('classes/CoreDB.class.php');
require_once('classes/DbDiff.class.php');
require_once('classes/json.class.php');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
if ($action) {
	json::print_headers();

	switch ($action) {

		case 'get_database':
			$json_data = json::show_databases($global_db_config);
			break;

		case 'export_schema':
			$json_data = json::export_schema($global_db_config);
			break;

		case 'compare_diff':
			$json_data = json::compare_diff($global_db_config);
			break;

		default:
			$json_data = (array('error'=>'Error','success'=>0));

	} // switch

	echo json_encode($json_data);
}




?>
