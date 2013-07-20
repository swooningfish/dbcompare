<!DOCTYPE html>
<html lang="en">
<head>
	<title>Database Compare</title>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

	<!-- jQuery-->
	<script src="js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
	<link href="css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet"/>

	<!-- Bootstrap via CDN-->
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet"/>

	<!-- Local JS -->
	<script src="js/dbcompare.js" type="text/javascript"></script>

	<!-- Local CSS -->
	<link href="css/style.css" rel="stylesheet"/>

</head>
	<body>
		<div id="wrap">
			<div class="container">

				<div class="row">
					<div class="span12">

						<h1>Database Compare</h1>

					</div>
				</div>

				<div class="row">
					<div class="span12">

						<h2 class="db_title pull-left" style="padding-right:10px;">Available Databases</h2>
						<button class="btn btn-mini btn-primary btn_add_database pull-left" type="button"><i class="icon-plus"></i> Add Database</button>
						<div class="clearfix"></div>
						<div class=" well">
							<div class="local_dbs">
								<!-- <button class="btn btn-small btn-primary" type="button">Default button</button> -->
								<div class="filler_20"></div>
								<p>test</p>
							</div>
						</div>

					</div>
				</div>

				<div class="filler_20"></div>

				<div class="row">
					<div class="span12">

						<div class="well">
							<p>Drag and drop the database above to the containers below to compare their schema's</p>

							<div class="db_setting_container_1 span4 offset1 pull-left">
								<h2 class="db_title">1st Databases Schema</h2>
								<div class="db_settings" id="db_1">
									<!-- Drop container for the database to compare -->
								</div>
								<textarea id="db_1_schema" class="db_schema"></textarea>
							</div>

							<div class="db_setting_container_2 span4 offset1 pull-left">
								<h2 class="db_title">2nd Databases Schema</h2>
								<div class="db_settings" id="db_2">
									<!-- Drop container for the database to compare -->
								</div>
								<textarea id="db_2_schema" class="db_schema" ></textarea>
							</div>

							<div class="clearfix"></div>

						</div>

					</div>
				</div>

				<div class="compare_container">
					<div class="row">
						<div class="span12">

							<p>
								<button class="btn btn-large btn-primary btn_compare offset4 span3" type="button"><i class="icon-eye-open"></i> Compare</button>
							</p>
						</div>
					</div>

					<div class="row">
						<div class="span12">
							<h3>Your Results will be shown here</h3>
							<div class="compare_log">
								<!-- results will be written here -->
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div id="dialog"></div>
	</body>
</html>
