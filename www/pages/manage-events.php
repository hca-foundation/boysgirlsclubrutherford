<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once '../app/global.php';

	//	Header
	$page_title = "Event Management";
	include_once '../header.php';

	if (!isLoggedIn()) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-events.php';
		
/////////////////////////////////////
// Ensure events are returned
		if (sizeof($results) > 0) {
?>
			<div class="container">
				<span><a class="pull-right btn btn-default" onclick="window.history.back();">Back</a></span>
				<h1>Event Listing</h1>
				<form id="event-search">
					<div class="form-group col-sm-2">
						<a href="#" class="btn btn-primary create-event" data-id="new"
													data-toggle="modal" 
													data-target="#edit-details" 
													onclick="editEvent(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<div class="form-group col-sm-10">
						<label for="search-events" class="sr-only">Search Events</label>
						<input class="form-control" id="search-events" name="search-events" placeholder="Search events" type="text" onkeyup="filterItems(this);return true;">
					</div>
				</form>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Event Name</th>
							<th>Event Date</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($results as $event) {
						?>
						<tr class="search-row" data-search="<?=$event["event_name"]?>">
							<td><?=$event["id"]?></td>
							<td><?=$event["event_name"]?></td>
							<td><?=$event["event_date"]?></td>
							<td>							
								<a href="#" class="edit-event manage-action" data-id="<?=$event["id"]?>" 
															data-name="<?= $event["event_name"] ?>"
															data-date="<?= $event['event_date'] ?>"
															data-toggle="modal" 
															data-target="#edit-details" 
															onclick="editEvent(this); return false;">
										<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
										<span class="sr-only">Edit</span>
								</a>
								<?php if ($event["active"] == 1) { ?>
									<a href="#" class="deactivate-task manage-action" data-id="<?=$event["id"]?>" 
																data-type='event'
																onclick="deactivate(this); return false;">
											<i class="glyphicon glyphicon-ban-circle" aria-hidden="true"></i>
											<span class="sr-only">Deactivate</span>
									</a>
								<?php } else { ?>
									<a href="#" class="activate-task manage-action" data-id="<?=$event["id"]?>" 
																data-type='event'
																onclick="activate(this); return false;">
											<i class="glyphicon glyphicon-certificate" aria-hidden="true"></i>
											<span class="sr-only">Activate</span>
									</a>
								<?php } ?>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>	

			<!-- event Detail Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Event Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="event-id" name="event-id" value="">
								<input type="hidden" id="type" name="type" value="event">

								<div class="form-group">
									<label for="event-name">Event Name</label>
									<input required
											class="form-control" 
											type="text" 
											id="event-name" 
											name="event-name" 
											value=""
											data-validation="true"
											data-validationtype="req"
											data-validationmessage="Please be sure to provide an event name.">
                </div>
                
                <div class="form-group">
									<label for="event-name">Event Date</label>
									<input required type='text' 
										class="form-control datetime-picker" 
										id="event-date-time-picker" 
										data-format="yyyy-MM-dd hh:mm:00" 
										name="event-date" 
										placeholder="MM/DD/YYYY 12:01 AM"  
										data-validation="true"
										data-validationtype="regex"
										data-validationregex="(0?[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.]\d{2,4}"
										data-validationmessage="Please be sure your event date is in the correct format."/>
								</div>
								<button type="submit" class="btn btn-success form-control">Save changes</button>
							</form>
						</div><!-- /modal-body -->
					</div><!-- /modal-content -->
				</div><!-- /modal-dialog -->
			</div><!-- /modal -->
<?php
		}
	}
	include_once '../footer.php';
?>