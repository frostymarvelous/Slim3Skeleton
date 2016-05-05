<?php
/**
 * Created by IntelliJ IDEA.
 * User: stefan.froelich
 * Date: 5/4/2016
 * Time: 5:11 PM
 */

$config = [];

$config['app'] = [
    'name' => 'app',
    'url' => 'http://slim.dev',
    'enable_sessions' => true,

    'settings' => [
        'debug' => true,
        'whoops.editor' => 'sublime',

        //  When true, additional information about exceptions are displayed by the default error handler.
        'displayErrorDetails' => true,

        //  The protocol version used by the Response object.
        #'httpVersion' => '1.1',

        //  Size of each chunk read from the Response body when sending to the browser.
        #'responseChunkSize' => 4096,

        //  If false, then no output buffering is enabled. If 'append' or 'prepend', then any echo or print statements
        //  are captured and are either appended or prepended to the Response returned from the route callable.
        #'outputBuffering' => 'append',

        //  When true, the route is calculated before any middleware is executed.
        //  This means that you can inspect route parameters in middleware if you need to.
        #'determineRouteBeforeAppMiddleware' => false,


    ]
];