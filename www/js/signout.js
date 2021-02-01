function signOut() {
	// Clear old error messages
	clearErrorMsgs();

	// AJAX Post to PHP
	$.ajax({
		type: "POST",
		url: signout_url,
		data: $("#sign-out-form").serialize(), // serializes the form's elements.
		success: function(data) {
			if (data.indexOf("ERROR") !== -1) {
				$(".danger").html(data);
			} else {
				// Redirect to thank you, but get hours
				var hours = "";
				if (data.indexOf("||") !== -1) {
					hours = data.substring(data.indexOf("||")+2,data.length);
					hours = hours.substring(0,hours.indexOf("||"));
				}
				location.href = 'thank-you.php?hours='+hours;
			}
		}
	});
	return false;
}