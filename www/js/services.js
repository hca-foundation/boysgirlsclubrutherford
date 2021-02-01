// Fires for all NPCB service call attribures on page load
// -> fired on page load in pageload.js 
function loadServiceData(element, service, callback, url_params) {
	var supported_services = ["locations", "job_type"];
	var url = service_url;
	if (supported_services.indexOf(service) !== -1) {
		url = url + service;
	}
	if (url_params !== "") {
		url = url + "&" + url_params;
    }
	$.get(url, function(results) {
		// Load the options up!
		results = JSON.parse(results);
		if (results.status === "Success" && results.data !== undefined) {
			// Call back with either error or success from above
			if (callback !== undefined && callback !== null && callback !== "") {						
				if (typeof callback === 'string') {
					window[callback](element, results);
				}
				//	else interpret callback as a function
				else {
					callback(element, results);
				}
			}
		} else {
			console.log("---> main.min.js - loadServiceData -> unable to pull data from service. Message is: " + results.message);
		}
	});
}