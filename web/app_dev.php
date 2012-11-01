<?php

use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
$allowed_ips = array(
    '127.0.0.1',
    '89.166.105.71',
    '::1');
$username = 'admin';
$password = 'kurppa6';
$ok = false;
if (isset($_SERVER['HTTP_CLIENT_IP']) || isset($_SERVER['HTTP_X_FORWARDED_FOR']) || ! in_array(@$_SERVER['REMOTE_ADDR'], $allowed_ips)) {
    if ($_SERVER['PHP_AUTH_PW'] == $password && $_SERVER['PHP_AUTH_USER'] == $username) {
        $ok = true;
    } else {
        header('WWW-Authenticate: Basic realm="Pulupalsta Authentication"');
        header('HTTP/1.0 401 Unauthorized');
        echo "You must enter a valid login ID and password to access this resource\n";
        exit;
    }
}

if (! $ok) {
    header('HTTP/1.0 403 Forbidden');
    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
