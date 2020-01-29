<?php
    // define a function that will allow us to validate the user's food input text
    function validFood($food) {
        return !empty(trim($food));
    }