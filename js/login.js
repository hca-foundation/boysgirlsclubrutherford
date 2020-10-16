// Login Page specific JavaScript

// Function that reveals the reset password div
$(function () {
	$(".reset-password").on("click", function(e) {
		e.preventDefault();
		$(".login-form-wrap").hide();
		$(".reset-password-wrap").slideDown();
	});
});