<?php
	// Error display
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	include_once '../app/global.php';

	//	Header
	$page_title = "Task Management";
	include_once '../header.php';

	if (!isLoggedIn()) {
		//	Session variable not set - redirect to login
		header("Location: " . $login_url);
	} else {
		// Logic
		include_once '../app/manage-tasks.php';
		
/////////////////////////////////////
// Ensure tasks are returned
		if (sizeof($results) > 1) {
?>
			<div class="container">
				<span><a class="pull-right btn btn-default" onclick="window.history.back();">Back</a></span>
				<h1>Task Listing</h1>
				<form id="task-search">
					<div class="form-group col-sm-2">
						<a href="#" class="btn btn-primary create-task" data-id="new"
													data-toggle="modal" 
													data-target="#edit-details" 
													onclick="editTask(this); return false;">
							<span><i class="glyphicon glyphicon-plus manage-action" aria-hidden="true"></i>Add New</span>
						</a>
					</div>
					<div class="form-group col-sm-10">
						<label for="search-tasks" class="sr-only">Search Tasks</label>
						<input class="form-control" id="search-tasks" name="search-tasks" placeholder="Search Tasks" type="text" onkeyup="filterItems(this);return true;">
					</div>
				</form>

				<table class="table table-striped table-responsive">
					<thead>
						<tr>
							<th>ID</th>
							<th>Task Name</th>
							<th>Is Active</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($results as $task) {
						?>
						<tr class="search-row" data-search="<?=$task["job_type"]?>">
							<td><?=$task["id"]?></td>
							<td><?=$task["job_type"]?></td>
							<td><?=$task["active"]?></td>
							<td>							
								<a href="#" class="edit-task manage-action" data-id="<?=$task["id"]?>" 
															data-name="<?=$task["job_type"]?>" 
															data-toggle="modal" 
															data-target="#edit-details" 
															onclick="editTask(this); return false;">
										<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>
										<span class="sr-only">Edit</span>
								</a>
								<?php if ($task["active"] == 1) { ?>
									<a href="#" class="deactivate-task manage-action" data-id="<?=$task["id"]?>" 
																data-type='job_type'
																onclick="deactivate(this); return false;">
											<i class="glyphicon glyphicon-ban-circle" aria-hidden="true"></i>
											<span class="sr-only">Deactivate</span>
									</a>
								<?php } else { ?>
									<a href="#" class="activate-task manage-action" data-id="<?=$task["id"]?>" 
																data-type='job_type'
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

			<!-- Task Detail Modal -->
			<div class="modal fade" id="edit-details" tabindex="-1" role="dialog" aria-labelledby="edit-label">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="edit-label">Task Details</h4>
						</div>
						<div class="modal-body">
							<form id="edit-details-form" method="POST" action="../app/manage.php">
								<input type="hidden" id="task-id" name="task-id" value="">
								<input type="hidden" id="type" name="type" value="job_type">

								<div class="form-group">
									<label for="task-name">Task Name</label>
									<input class="form-control" type="text" id="task-name" name="task-name" value="">
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