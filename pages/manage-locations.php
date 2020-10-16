<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once '../app/global.php';

	//	Header
	$page_title = "Location Management";
	include_once '../header.php';

	if (!isset($_SESSION['email'])) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-locations.php';
		
/////////////////////////////////////
// Ensure locations are returned
		if (sizeof($results) > 1) {
?>
			<div class="container">
				<h1>Location Listing</h1>
				<form id="loc-search">
					<div class="form-group col-sm-2">
						<a href="#" class="btn btn-primary create-location" data-id="new"
													data-toggle="modal" 
													data-target="#edit-details" 
													onclick="editLocation(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<div class="form-group col-sm-10">
						<label for="search-locs" class="sr-only">Search Locations</label>
						<input class="form-control" id="search-locs" name="search-locs" placeholder="Search Locations" type="text" onkeyup="filterItems(this);return true;">
					</div>
				</form>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Location Name</th>
							<th>Is Active</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($results as $location) {
						?>
						<tr class="search-row" data-search="<?=$location["location_name"]?>">
							<td><?=$location["id"]?></td>
							<td><?=$location["location_name"]?></td>
							<td><?=$location["active"]?></td>
							<td>							
								<a href="#" class="edit-location manage-action" data-id="<?=$location["id"]?>" 
															data-name="<?=$location["location_name"]?>" 
															data-toggle="modal" 
															data-target="#edit-details" 
															onclick="editLocation(this); return false;">
										<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
										<span class="sr-only">Edit</span>
								</a>
								<?php if ($location["active"] == 1) { ?>
									<a href="#" class="deactivate-location manage-action" data-id="<?=$location["id"]?>" 
																data-type='location'
																onclick="deactivate(this); return false;">
											<i class="glyphicon glyphicon-ban-circle" aria-hidden="true"></i>
											<span class="sr-only">Deactivate</span>
									</a>
								<?php } else { ?>
									<a href="#" class="activate-location manage-action" data-id="<?=$location["id"]?>" 
																data-type='location'
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

			<!-- Location Detail Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Location Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="loc-id" name="loc-id" value="">
								<input type="hidden" id="type" name="type" value="location">

								<div class="form-group">
									<label for="loc-name">Location Name</label>
									<input class="form-control" type="text" id="loc-name" name="loc-name" value="">
								</div>
								<button type="submit" class="btn btn-success">Save changes</button>
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