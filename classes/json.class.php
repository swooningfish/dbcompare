<?php

/**

 * Copyright (C) 2013, Greg Colley
 * Available under http://en.wikipedia.org/wiki/MIT_License
 *
 * @author Greg Colley
 */

class json  {

	/**
	 * json::print_headers()
	 *
	 * @return
	 */
	function print_headers(){
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');
	}

	/**
	 * json::show_databases()
	 *
	 * @return
	 */
	function show_databases($global_db_config){
		list($success,$databases,$error) = DbDiff::show_databases($global_db_config);
		return array('success'=>$success,'databases'=>$databases,'count'=>count($databases),'error'=>$error);
	}

	function compare_diff($global_db_config){

		$data_array = array('success'=>0,'error'=>'Error - Both schemas must be given.','data'=>false,'html'=>'');

		$schema1 = isset($_REQUEST['db_1_schema']) ? $_REQUEST['db_1_schema'] : null;
		$schema2 = isset($_REQUEST['db_2_schema']) ? $_REQUEST['db_2_schema'] : null;

		$data = false;
		$html = "";

		if (empty($schema1) || empty($schema2)) {
			$data_array['error'] = 'Both schemas must be given.';

		}
		else
		{
			$unserialized_schema1 = unserialize(strip_nl($schema1));
			$unserialized_schema2 = unserialize(strip_nl($schema2));

			$results = DbDiff::compare($unserialized_schema1, $unserialized_schema2);

			if (count($results) > 0) {
				$data = array(
								'differences_found'=>$results,
								'count_tables'=>$results,
								'tables'=>array(),
							 );

				$html .= '<h3>Found differences in ' . count($results) . ' table' . s(count($results)) . ':</h3>';

				$html .= '<ul id="differences">';
				foreach ($results as $table_name => $differences) {
					$data['tables'][$table_name] = array('table_name'=>$table_name,'differances'=>array());


					$html .= '<li><strong>' . $table_name . '</strong><ul>';
					foreach ($differences as $difference) {
						$data['tables'][$table_name]['differances'][] = $difference;
						$html .= '<li>' . $difference . '</li>';
					}
					$html .= '</ul></li>';
				}
				$html .= '</ul>';

			} else {
				$html .= '<p>No differences found.</p>';
			}



			$data_array['success'] = 1;
			$data_array['error'] = "";
			$data_array['data'] = $data;
			$data_array['html'] = $html;
		}

		return $data_array;
	}

	/**
	 * json::export_schema()
	 *
	 * @return
	 */
	public static function export_schema($global_db_config)
	{
		$data_array = array('success'=>0,'error'=>'Error - No database specified','data'=>'',);

		$db_name = isset($_REQUEST['db_name']) ? $_REQUEST['db_name'] : null;

		$db_host = isset($_REQUEST['db_host']) ? $_REQUEST['db_host'] : $global_db_config['host'];
		$db_user = isset($_REQUEST['db_user']) ? $_REQUEST['db_user'] : $global_db_config['user'];
		$db_pass = isset($_REQUEST['db_password']) ? $_REQUEST['db_password'] : $global_db_config['password'];

		if ($db_name) {

			if (!$db_host || !$db_user || !$db_pass) {
				$data_array['error'] = 'No database configuration entered.';

			}

			$db_config = array(
				'host' => $db_host,
				'user' => $db_user,
				'password' => $db_pass,
				'name' => $db_name,
			);

			$result = DbDiff::export($db_config,$db_name);

			if ($result == null) {
				$data_array['error'] = 'Couldn\'t connect to database: ' . mysql_error();
			}
			else
			{
				$serialized_schema = serialize($result);
				$data_array['data'] = chunk_split($serialized_schema, 100);
				$data_array['success'] = 1;
				$data_array['error'] = '';
			}
		}

		return $data_array;

	}
}

?>