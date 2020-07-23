/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import '../css/app.css';
import '../css/app.css';
import '../css/nav.css';
import '../css/weather-icons.min.css';
import '../css/style.css';
import '../css/style-additional.css';
// import '../css/footer.css';

// require('@fortawesome/fontawesome-free/css/all.min.css');

// require('@fortawesome/fontawesome-free/js/all.min.js');
// require('@fortawesome/fontawesome-free/js/brands.min.js');
// require('@fortawesome/fontawesome-free/js/conflict-detection.min.js');
// require('@fortawesome/fontawesome-free/js/fontawesome.min.js');
// require('@fortawesome/fontawesome-free/js/regular.min.js');
// require('@fortawesome/fontawesome-free/js/solid.min.js');
// require('@fortawesome/fontawesome-free/js/v4-shims.min.js');

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';


// loads the jquery package from node_modules
var $ = require('jquery');
require('bootstrap-sass');

$(document).ready(function() {
	console.log('Hello');	
});


