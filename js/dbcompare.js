/**

 * Copyright (C) 2013, Greg Colley
 * Available under http://en.wikipedia.org/wiki/MIT_License
 *
 * @author Greg Colley
*/

function myHelper( event ) {
	var database = event.target.id;
	return '<a class="btn btn-mini local_db" style="margin:2px;" id="'+database+'"><i class="icon-list-alt"></i> '+database+'</a>';
}

function handleDropEvent( event, ui ) {
	var draggable = ui.draggable;
	var db_name = draggable.attr('id');

	var dropped = $(this);

	// Clear the results if any just incase the ajax does not retrun anything
	$(dropped).next('.db_schema').val('');

	// Show loading image
	$(dropped).html('<img src="images/ajax-loader.gif"/>');

	// Perform ajax request to get the database schema
	jQuery.ajax({
		type: "POST",
		url: "json.php",
		data: {action:'export_schema',db_name:db_name},
		dataType: "json",
		success: function(data) {
			// Close the dialog box
			if (data.success) {

				// Placeholder to show that there is a database loaded.
				$(dropped).html('<a class="btn btn-mini dropped_db" style="margin:2px;" id="'+draggable.attr('id')+'"><i class="icon-list-alt"></i> '+draggable.attr('id')+'</a>');

				// Load the database scheme into the hidden textarea
				$(dropped).next('.db_schema').val(data.data);

				var db_1_schema = $('#db_1_schema').val().length;
				var db_2_schema = $('#db_2_schema').val().length;

				if ( db_1_schema == 0 || db_2_schema == 0 ) {
					// Hide the compare button &results
					$('.compare_container').hide();
				}
				else
				{
					// Showthe compare button &results
					$('.compare_container').show();

					// Clear the compare_log for any previous results
					$('.compare_log').html('Click the compare button to see the database comparason');
				}
			}
			else
			{
				// Display a error
				jQuery("#dialog").attr("title", "ERROR");
				jQuery('#dialog').html("ERROR - "+data.error);
				jQuery('#dialog').dialog({ 	// http://docs.jquery.com/UI/Dialog

					width:400,
					resizable: false,
					modal: true,
					buttons: [
					{
						text: "Close",
						"class": 'btn',
						click:  function() {
							jQuery( this ).dialog( "close" );
						}
					}
					],
					open: function(){
						// Open code here
						$(this).parent().parent().find('.ui-dialog-titlebar-close').remove();
					},
					close: function(){
						// Close code here
					}
				});
			}
		},
		// Create a dialog box for failed ajax responce
		error:function (xhr, ajaxOptions, thrownError){
			jQuery("#dialog").attr("title", "ERROR - "+xhr.status);
			jQuery('#dialog').html("ERROR - "+xhr.status + ' <br/>' + thrownError);
			jQuery('#dialog').dialog({ 	// http://docs.jquery.com/UI/Dialog
				width:400,
				resizable: false,
				modal: true,
				buttons: [
				{
					text: "Close",
					"class": 'btn',
					click:  function() {
						jQuery( this ).dialog( "close" );
					}
				}
				],
				open: function(){
					// Open code here
					$(this).parent().parent().find('.ui-dialog-titlebar-close').remove();
				},
				close: function(){
					// Close code here
				}
			});
		} // Error
	});

}

function renderReloadDatabases(message){
	jQuery('.local_dbs').html(message);
	jQuery('.local_dbs').append('<a class="btn btn-small btn_reload_db" style="margin:2px;"><i class="icon-list-alt"></i> Retry loading databases</a>');

	jQuery('.btn_reload_db').on("click",function(e){
		getDatabases();
	});
}

function getDatabases() {

	$('.local_dbs').html('<img src="images/ajax-loader.gif"/>');
	jQuery.ajax({
		type: "POST",
		url: "json.php",
		data: {action:'get_database'},
		dataType: "json",
		success: function(data) {
			$('.local_dbs').html('');
			// Close the dialog box
			if (data.success) {

				if (data.count) {
					// loop around the results of databases and pop them into the local_dbs div
					$.each(data.databases, function(key, database){
						jQuery('.local_dbs').append('<a class="btn btn-small btn_local_db local_db" style="margin:2px;" id="'+database+'"><i class="icon-list-alt"></i> '+database+'</a>');
					});

					// Assign the local databases so they can be dragged
					$('.btn_local_db').draggable({
						//containment: '.span6',
						//snap: '.span6',
						cursor: 'move',
						helper: myHelper
					});

					// Setup the database droppable areas
					$('.db_settings').droppable( {
						drop: handleDropEvent
					});
				}
				else
				{
					// No databases found
					renderReloadDatabases('<p class="error">No databases found check the include and exclude array in the config.php</p>');

				}


			}
			else
			{
				renderReloadDatabases('<p class="error">'+data.error+'</p>');
			}
		},
		// Create a dialog box for failed ajax responce
		error: function (xhr, ajaxOptions, thrownError){

			// Add the reload button to the local_dbs
			renderReloadDatabases('<p class="error">ERROR - '+xhr.status + ' (' + thrownError+')</p>');

			jQuery("#dialog").attr("title", "ERROR - "+xhr.status);
			jQuery('#dialog').html("ERROR - "+xhr.status + ' <br/>' + thrownError);
			jQuery('#dialog').dialog({ 	// http://docs.jquery.com/UI/Dialog
				width:400,
				resizable: false,
				modal: true,
				buttons: [
				{
					text: "Close",
					"class": 'btn',
					click:  function() {
						jQuery( this ).dialog( "close" );
					}
				}
				],
				open: function(){
					// Open code here
					$(this).parent().parent().find('.ui-dialog-titlebar-close').remove();
				},
				close: function(){
					// Close code here
				}
			});
		} // Error
	});
}


jQuery(document).ready(function() {

	// Init
	$('.db_schema').val('');

	// Get the databases via ajax and populate the page
	getDatabases();


	// Listner for db compare button
	jQuery('.btn_compare').on("click",function(e){
		e.preventDefault();

		// Get the schema's
		var db_1_schema = $('#db_1_schema').val();
		var db_2_schema = $('#db_2_schema').val();

		$('.compare_log').html('<img src="images/ajax-loader.gif"/>');

		// Ajax post to compare the schemas
		jQuery.ajax({
			type: "POST",
			url: "json.php",
			data: {action:'compare_diff',db_1_schema: db_1_schema, db_2_schema: db_2_schema},
			dataType: "json",
			success: function(data) {
				// Close the dialog box
				if (data.success) {
					// Output to the html file
					$('.compare_log').html(data.html);
				}
				else
				{

					//$('.compare_log').html(data.error);

					// Clear the compare_log loading image
					$('.compare_log').html('');

					// Show error dialog
					jQuery("#dialog").attr("title", data.error);
					jQuery('#dialog').html("ERROR - "+data.error);
					jQuery('#dialog').dialog({ 	// http://docs.jquery.com/UI/Dialog
						width:400,
						resizable: false,
						modal: true,
						buttons: [
						{
							text: "Close",
							"class": 'btn',
							click:  function() {
								jQuery( this ).dialog( "close" );
							}
						}
						],
						open: function(){
							// Open code here
							$(this).parent().parent().find('.ui-dialog-titlebar-close').remove();
						},
						close: function(){
							// Close code here
						}

					});

				}
			},
			// Create a dialog box for failed ajax responce
			error:function (xhr, ajaxOptions, thrownError){


				jQuery("#dialog").attr("title", "ERROR - "+xhr.status);
				jQuery('#dialog').html("ERROR - "+xhr.status + ' <br/>' + thrownError);
				jQuery('#dialog').dialog({ 	// http://docs.jquery.com/UI/Dialog

					resizable: false,
					modal: true,
					buttons: [
						{
							text: "Close",
							"class": 'btn',
							click:  function() {
								jQuery( this ).dialog( "close" );
							}
						}
					],
					open: function(){
						// Open code here
						$(this).parent().parent().find('.ui-dialog-titlebar-close').remove();
					},
					close: function(){
						// Close code here
					}

				});
			} // Error
		});

	});


}); // doc ready
