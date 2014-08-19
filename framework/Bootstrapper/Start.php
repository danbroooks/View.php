<?php

require('Functions.php');

require('Bootstrapper.php');

Bootstrapper::init();

require('site/_config.php');

Router::route();
