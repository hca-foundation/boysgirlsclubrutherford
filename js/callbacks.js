// Loads the passed drop down with the results passed
function loadDropdown(element, results) {
	var html = "";
	for (var i = 0; i < results.data.length > 0; i++) {
		var data_item = results.data[i];
		// Special condition - meal prep should ALWAYS be shown first in the list
		if (data_item.name === "Meal Prep") {
			html = "<option value='" + data_item.id + "'>" + data_item.name + "</option>" + html;
		} else {
			html += "<option value='" + data_item.id + "'>" + data_item.name + "</option>";	
		}
	}
	$(element).append(html);	
}

// Callback for job type service
function jobTypeCallback(element, results) {
	loadDropdown(element, results);
}

// Callback for Location service
function locationCallback(element, results) {
	loadDropdown(element, results);
	checkPreferences();
}