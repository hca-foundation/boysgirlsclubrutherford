// Global Vars
var domain = document.getElementById("npcb-env").value;
var protocol = document.getElementById("npcb-protocol").value + ":";
var service_url = protocol + "//" + domain + "/app/services.php?service=";
var signin_url = protocol + "//" + domain + "/app/signin.php";
var signout_url = protocol + "//" + domain + "/app/signout.php";
var quick_signin = $("#quick-sign-in-name");

//////////////////////
// AUTOPOPULATE DATES
//////////////////////
window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>');
var today = new Date();
$('#myDate').val(today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2));

// sets up formatting for tel inputs
$('input[type="tel"]').usPhoneFormat({
	format: '(xxx) xxx-xxxx'
});

// Handline invalid input
function handleInvalid(msg) {
	var error_divs = document.querySelectorAll(".danger");
	for (var i = 0; i < error_divs.length; i++) {
		error_divs[i].innerHTML = "<p class='alert alert-danger'>" + msg + "</p>";
	}
	return false;
}

// Clear all error messages
function clearErrorMsgs() {
	var error_divs = document.querySelectorAll(".danger");
	for (var i = 0; i < error_divs.length; i++) {
		error_divs[i].innerHTML = "";
	}
}

// for auto populating fields :-)
function botamatic() {
	$("input[name='firstname']").val("Rusty");
	$("input[name='lastname']").val("Von Shackleford");
	$("input[name='email']").val("backwoods007@shackleford.edu");
	$("input[name='phone']").val("(222) 333-4444");
	$("input[name='dob']").val("01/01/1982");
	document.getElementById('location').value = 3;
	document.getElementById('task').value = 2;	
}

// Get URL parameters
function getParameterByName(name, url) {
	if (!url) {
		url = window.location.href;
	}
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	results = regex.exec(url);
	if (!results) {
		return null;
	}
	if (!results[2]) {
		return '';
	}
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// Set input group addon values
// Switches required field indicators from ERROR to OK if text entered 
function flipInputGroupIcon(querySelector, status) {
	var field_inputs = document.querySelectorAll(querySelector);
	for (var i = 0; i < field_inputs.length; i++) {
		// input-group-addon has field-* and the child <i> has the glyphicon
		if (status === "ok") {
			$(field_inputs[i]).addClass("field-ok").removeClass("field-error");
			$(field_inputs[i]).children().addClass("glyphicon-ok").removeClass("glyphicon-asterisk");
		} else {
			$(field_inputs[i]).addClass("field-error").removeClass("field-ok");
			$(field_inputs[i]).children().addClass("glyphicon-asterisk").removeClass("glyphicon-ok");			
		}
	}
}

// Function to submit a Form from JavaScript
function post(path, params, method) {
	method = method || "post"; // Set method to post by default if not specified.
	// The rest of this code assumes you are not using a library.
	// It can be made less wordy if you use one.
	var form = document.createElement("form");
	form.setAttribute("method", method);
	form.setAttribute("action", path);
	for(var key in params) {
		if(params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);
			form.appendChild(hiddenField);
		}
	}
	document.body.appendChild(form);
	form.submit();
}

// Setting preferences from the index page
function setPreferences() {
	// Get location and store in local storage
	if (typeof (Storage) !== "undefined") {
		var location_value = document.getElementById("location").value;
		if (location_value !== "") {
			localStorage.setItem("location", location_value);
		}
		document.getElementById("prefs-set").innerHTML = "<p>Preferences Set!</p>";
	} else {
		document.getElementById("prefs-failed").innerHTML = "<p>Sorry! This browser doesn't support local storage or setting of preferences!</p>";
	}
}

// Checking preferences setup on the index page
function checkPreferences() {
	// Check for preferences
	if (typeof (Storage) !== "undefined" && window.location.pathname.indexOf("dashboard.php") === -1) {
		var location_value = localStorage.location;
		if (location_value !== undefined && location_value !== "") {
			var element = document.getElementById('location');
			if (element !== null && element !== undefined) {
				element.value = location_value;
				// Check off that req field is now valid
				flipInputGroupIcon(".location .input-group-addon", "ok");
			}
		}
	}
}

// Form Validation
function checkIfValid(formId) {
	var is_valid = true;
	var validation_fields = document.getElementById(formId).querySelectorAll("[data-validation]");
	for (var i = 0; i < validation_fields.length; i++) {
		var validation_field = validation_fields[i];
		// Get value - check for input vs select
		var field_value = "";
		if (validation_field.nodeName.toLowerCase() === "select") {
			field_value = validation_field.options[validation_field.selectedIndex].value.trim();
		} else {
			field_value = validation_field.value.trim();
        }
		switch (validation_field.dataset.validationtype) {
			case "regex":
				is_valid = (field_value.match(new RegExp(validation_field.dataset.validationregex))) ? true : validation_field.dataset.validationmessage;
				break;
			case "req":
				is_valid = (field_value !== "") ? true : validation_field.dataset.validationmessage;				
				break;
			default:
				// Do nothing - validation not setup correctly
		}
		if (is_valid !== true) {
			validation_field.classList.add("validation-error");
			break;
		} else {
			validation_field.classList.remove("validation-error");
        }
	}
	return is_valid;
}