<?php
/**
 * Created by IntelliJ IDEA.
 * User: stefan.froelich
 * Date: 5/4/2016
 * Time: 5:11 PM
 */

$config = [];

$config['database'] = [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => '',
    'username'  => '',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];

// Remove following line after configuration
//throw new \Configula\ConfigulaException('Database not configured!');