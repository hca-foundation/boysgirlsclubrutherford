//////////////////////////////////////////
// REPORTING
//////////////////////////////////////////

// Signout all users
function signout() {
    if (window.confirm("Are you sure you want to sign everyone out? 4 hours will be logged for each volunteer.")) {
        window.location.href = "/pages/autosignout.php";
    } else {
        return false;
    }
}

// Resets the dashboard
function resetDashboard() {
    if (document.getElementsByName("vol_name").length > 0) {
        document.getElementsByName("vol_name")[0].options[0].selected = "selected";
    }
    document.getElementsByName("task")[0].options[0].selected = "selected";
    document.getElementsByName("location")[0].options[0].selected = "selected";
    document.getElementsByName("endtime")[0].value = "";
    document.getElementsByName("starttime")[0].value = "";
}