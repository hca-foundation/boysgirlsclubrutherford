// Sign in Volunteer
function signIn() {

	// Clear old errors
	clearErrorMsgs();

	// Validate Fields
	var valid_form = checkIfValid("sign-in-form");
	if (valid_form !== true) {
		return handleInvalid(valid_form);
    } else {
		// AJAX Post to PHP
		$.ajax({
			type: "POST",
			url: signin_url,
			data: $("#sign-in-form").serialize(), // serializes the form's elements.
			success: function (data) {
				if (data.indexOf("ERROR") !== -1) {
					$(".danger").html(data);
				} else {
					// Redirect to Thank you
					location.href = 'thank-you.php';
                }
			}
		});
	}
	return false;
}