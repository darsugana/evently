#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

echo User::generatePassword() . "\n";