// Manage Pages JavaScript

// Update a Location Modal
function editLocation(location_sel) {
	var id = $(location_sel).data("id");
	if (id !== "new") {
		$("#loc-name").attr("value", $(location_sel).data("name"));
		$("#loc-internal").attr("value", $(location_sel).data("internal"));
		$("#loc-id").attr("value", id);
	} else {
		$("#loc-name").attr("value", "");
		$("#loc-internal").attr("value", "");
		$("#loc-id").attr("value", "new"); // new is required as value to ensure we are creating a new location - security and logic reasons
	}
}

// Update a Task Modal
function editTask(task_sel) {
	var id = $(task_sel).data("id");
	if (id !== "new") {
		$("#task-name").attr("value", $(task_sel).data("name"));
		$("#task-id").attr("value", id);
	} else {
		$("#task-name").attr("value", "");
		$("#task-id").attr("value", "new"); // new is required as value to ensure we are creating a new location - security and logic reasons
	}
}

// Update the Volunteer Period Modal
function editPeriod(vol_period_sel) {
	$("#vol-period-id").attr("value", $(vol_period_sel).data("id"));
	$("#signin-datetime-picker").val($(vol_period_sel).data("signin"));
	$("#signout-datetime-picker").val($(vol_period_sel).data("signout"));
	$("#organization").attr("value", $(vol_period_sel).data("org"));
	$("#task").val($(vol_period_sel).data("activity"));
	$("#location").val($(vol_period_sel).data("location"));
}

// Deactivate
function deactivate(item_to_deactivate) {
	var id = item_to_deactivate.dataset.id;
	var type = item_to_deactivate.dataset.type;
	if (confirm("Are you sure you want to deactivate this " + type + "? This will disable this item everywhere except in reporting.")) {
		post("../app/manage.php", { id: id, 'item-type': type, type: "deactivate" }, "POST");
	} else {
		return handleInvalid("Deactivation of " + type + " cancelled.");
	}
}

// Activate
function activate(item_to_activate) {
	var id = item_to_activate.dataset.id;
	var type = item_to_activate.dataset.type;
	if (confirm("Are you sure you want to activate this " + type + "?")) {
		post("../app/manage.php", { id: id, 'item-type': type, type: "activate" }, "POST");
	} else {
		return handleInvalid("Activation of " + type + " cancelled.");
	}
}

// Search volunteers
var search_rows = document.getElementsByClassName("search-row");
function filterItems(search_field) {
	// Start the search
	for (var i = 0; i < search_rows.length; i++) {
		search_row = search_rows[i];
		var found = search_row.dataset.search.toLowerCase().indexOf(search_field.value.toLowerCase());
		if (found === -1) {
			search_row.classList.add("hidden");
		} else if (found !== -1) {
			search_row.classList.remove("hidden");
		}
	}
}