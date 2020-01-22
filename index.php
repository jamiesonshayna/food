<?php
/**
 * @author Shayna Jamieson
 * @version 1.0
 * URL: http://sjamieson.greenriverdev.com/328/food/index.php
 * Date: January 22, 2020
 * Description: This file serves to define a default route. When a user navigates to
 * the route of our directory they will be taken to the view that we have defined as views/home.html
 */

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("vendor/autoload.php");

// instantiate F3
$f3 = Base::instance(); // invoke static

// define a default route
// when the user navigates to the route directory of the project
// this is what they should see
$f3->route('GET /', function() {
    // create a new view object by instantiating the fat-free templating class
    $view = new Template();

    // on the object template we render the home page through this route
    echo $view->render('views/home.html');
});

// define another route for breakfast (not default)
$f3->route('GET /breakfast', function() {
   $view = new Template();
   echo $view->render('views/breakfast.html');
});

// define a sub route for breakfast page called 'buffet'
$f3->route('GET /breakfast/buffet', function() {
    $view = new Template();
    echo $view->render('views/breakfast-buffet.html');
});

// define another route for lunch (not default)
$f3->route('GET /lunch', function() {
    $view = new Template();
    echo $view->render('views/lunch.html');
});

// *** NEW *** Define a route that accepts a food parameter
// here is a route that will accept our value: https://sjamieson.greenriverdev.com/328/food/watermelon
$f3->route('GET /@item', function($f3, $params) { // @ is a placeholder
    // f3 is fat free object instantiated above
    // params are optional and its what we pass (array) (second arg needs 1st put in)
    //var_dump($params);
    $item = $params['item'];
    echo "<h1 style='color: pink;'>You ordered $item</h1>";

    // check if the param food is in our 'current stock' and display message
    $foodsWeServe = array("tacos", "pizza", "lumpia");
    if(!in_array($item, $foodsWeServe)) {
        echo "<h3 style='color:green;'>Sorry we don't serve $item</h3>";
    }

    // test with a switch
    switch($item) {
        case 'tacos':
            echo "<p>We serve tacos on Tuesday!</p>";
            break;
        case 'pizza':
            $f3->reroute("/lunch");
            break;
        case 'watermelon':
            echo "<p>Smart choice.</p>";
            break;
        default:
            $f3->error(404); // if none are chosen display a 404 error page
    }
});

// define another route called order that displays a form
$f3->route('GET /order', function() {
    $view = new Template();
    echo $view->render('views/form1.html');
});

// create a route for order #2 (we go here from form1.html with post)
$f3->route('POST /order2', function() {
    $view = new Template();
    echo $view->render('views/form2.html');
});

// create a route for order #2 (we want to go to our summary page)
$f3->route('POST /summary', function() {
    $view = new Template();
    echo $view->render('views/results.html');
});

// fun Fat-Free
$f3->run();

