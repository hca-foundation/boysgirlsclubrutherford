// Imports
var gulp = require('gulp');
var concat = require('gulp-concat');

// JavaScript files that need to be concatenated
js_files = ["node_modules/jquery/dist/jquery.min.js"
    , "node_modules/jquery-input-mask-phone-number/dist/jquery-input-mask-phone-number.min.js"
    , "node_modules/bootstrap/dist/js/bootstrap.min.js"
    , "node_modules/moment/min/moment.min.js"
    , "node_modules/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"
    , "js/global.js"
    , "js/callbacks.js"
    , "js/services.js"
    , "js/signin.js"
    , "js/signout.js"
    , "js/pageload.js"
    , "js/pagination.js"
    , "js/report.js"
    , "js/login.js"
    , "js/manage.js"
    , "js/downloadCSV.js"
]

// CSS files that need to be concatenated
css_files = ["node_modules/bootstrap/dist/css/bootstrap.min.css"
    , "node_modules/bootstrap/dist/css/bootstrap-theme.min.css"
    , "node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"
    , "css/style.css"
]

// Generic function to run concatenation of JavaScript files
function concat_files(src_arr, filename) {
    return gulp.src(src_arr)
		.pipe(concat(filename))
		.pipe(gulp.dest('.'));
}

// Concat function for running JavaScript Only
function build_js() {
    return concat_files(js_files, "js/main.min.js");
}

// Concat function for running JavaScript Only
function build_css() {
    return concat_files(css_files, "css/app.min.css")
}

// Concat function for running all
function pass_param() {
    return new Promise(function (resolve, reject) {
        console.log("----> COMPLIATION FAILED: You must pass parameter 'js' or 'css' to compile.");
        resolve();
    });
}

// Setup of concat function. From command line type: gulp concat
// Minification is not done here as once we put the code into a Tag in GTM, GTM does it's own minification
exports.default = pass_param;
exports.js = build_js;
exports.css = build_css;