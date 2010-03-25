#!/usr/bin/env php
<?php
include(dirname(dirname(__FILE__)) . '/config/application.php');

$user = User::constructByKey(1);
$user->setPassword('rp4321');
$user->save();
print_r(User::constructByEmailAndPassword('pistole@rhp.org', 'rp4321'));
print_r(User::constructByEmailAndPassword('pistole@rhp.org', 'jdhsakljh'));
