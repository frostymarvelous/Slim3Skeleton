<?php
/**
 * Created by IntelliJ IDEA.
 * User: stefan.froelich
 * Date: 5/4/2016
 * Time: 5:11 PM
 */

$config = [];

$config['services'] = [
    // View settings
    'view' => [
        'template_path' => DIR_APP . 'templates',
        'cache' => DIR_STORAGE . 'cache/blade',
    ],

    // monolog settings
    'logger' => [
        'path' => DIR_STORAGE . 'logs/' . date('Y-m-d') . '.log',
        'level' => \Monolog\Logger::DEBUG,
    ],
];