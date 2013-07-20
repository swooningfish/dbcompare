<?php

/**

 * Copyright (C) 2013, Greg Colley
 * Available under http://en.wikipedia.org/wiki/MIT_License
 *
 * @author Greg Colley
 */

class CoreDB  {

	/**
	 * DbDiff::show_databases()
	 *
	 * @param mixed $config
	 * @return
	 *
	 * Author : Greg Colley
	 */
	function show_databases($config){

		$exclude_databases = $config['exclude_databaes'];
		$include_databases = $config['include_databaes'];

		$error = "";
		$success = 0;

		$db = @mysql_connect($config['host'], $config['user'],	$config['password']);
		if (!$db) {
			$error = 'Error - Unable to connect to local db server, please check your settings in the config.php '. mysql_error();
		}


		$res = mysql_query("SHOW DATABASES");

		$databases = array();
		while ($row = mysql_fetch_assoc($res)) {
			if ($config['use_includes']) {
				if (in_array($row['Database'],$include_databases)) {
					$databases[] = $row['Database'];
				}
			}
			else
			{
				if (!in_array($row['Database'],$exclude_databases)) {
					$databases[] = $row['Database'];
				}
			}

		}

		mysql_close();

		if ($error == "") {
			if (count($databases > 0) ) {
				$success = 1;
			}
			else
			{
				$error = 'No databases found';
			}
		}

		return array($success,$databases,$error);

	}

}

?>