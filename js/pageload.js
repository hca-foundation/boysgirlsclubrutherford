//////////////////////
// PAGE LOAD
//////////////////////

// For safari specific functionality
var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

// On load
window.addEventListener("load",function() {

	// Check for hours passed in the URL
	var hours = getParameterByName('hours'); // "lorem"
	if (hours !== undefined && hours !== null && hours !== "") {
		$("#hours").html(hours);
		$("#hours-worked").show();
	}
	
	// Botomatic (in global.js) - used for testing
	//botamatic();
	
	// Setup datetime picker defaults / check for status page
	if (document.getElementById("startdate-default")) {
		var default_start_date = document.getElementById("startdate-default").value;
	}
	if (document.getElementById("enddate-default")) {
		var default_end_date = document.getElementById("enddate-default").value;		
	}
	var default_datetime_picker_options = {
		"useCurrent": true,
		"stepping":5
	};
	
	// Dashboard Page
	if (default_start_date || default_end_date) {
		if(default_end_date) {
			$("#end-datetime-picker").datetimepicker({
				"defaultDate": default_end_date,
				"stepping":5
			});
		} else {
			$("#end-datetime-picker").datetimepicker(default_datetime_picker_options);			
		}
		if(default_start_date) {
			$("#start-datetime-picker").datetimepicker({
				"defaultDate": default_start_date,
				"stepping":5
			});
		} else {
			$("#start-datetime-picker").datetimepicker(default_datetime_picker_options);
		}
	// All other pages
	} else {		
		$(".datetime-picker").datetimepicker(default_datetime_picker_options);
	}

	// Check / Set preferences - preferences currently is only the default location set at clock in
	checkPreferences();

	//////////////////////
	// SERVICE CALLS
	//////////////////////
	// Make calls to the service for all items matching the npcb-service class on the page and load the data
	var service_calls = $(".npcb-service");
	for (var i = 0; i < service_calls.length; i++) {
		var service_call = service_calls[i];
		if($(service_call).data("npcb-service")) {
			// Only run if data is populated
			var service = $(service_call).data("npcb-service");
			var callback = "";
			if ($(service_call).data("npcb-callback") !== "") {
				callback = $(service_call).data("npcb-callback");
			}		
			loadServiceData(service_call, service, callback, "");
		}
	}
	
	//////////////////////
	// ON EVENT HANDLERS
	//////////////////////

	// Set datetime picker time and flip the ok switch on that input
	$(".datetime-picker").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".signin-time .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".signin-time .input-group-addon", "error");
		}
	});
	$(".datetime-picker").focus().blur();
	$("#quick-sign-in-name").focus();

	// Setup on change for task drop down
	$("#task").on("change",function() {
		if ($(this).find(":selected").val() !== "") {
			flipInputGroupIcon(".task .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".task .input-group-addon", "error");
		}
	});
	
	// Setup on change for location drop down
	$("#location").on("change",function() {
		if ($(this).find(":selected").val() !== "") {
			flipInputGroupIcon(".location .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".location .input-group-addon", "error");
		}
	});
	
	// Setup on change for email
	$("#quick-sign-in-name").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".email .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".email .input-group-addon", "error");
		}
	});
	
	// Setup on change for first and last name
	$("#first-name").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".first-name .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".first-name .input-group-addon", "error");
		}
	});
	
	// Setup on change for first and last name
	$("#last-name").on("blur",function() {
		if ($(this).val() !== "") {
			flipInputGroupIcon(".last-name .input-group-addon", "ok");
		} else {
			flipInputGroupIcon(".last-name .input-group-addon", "error");
		}
	});
		
	// Scroll to top
	jQuery('html,body').animate({scrollTop:0},200);

});