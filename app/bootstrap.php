<?php
/**
 * Created by IntelliJ IDEA.
 * User: stefan.froelich
 * Date: 5/4/2016
 * Time: 4:49 PM
 */

define('DIR_ROOT', dirname(__DIR__) . '/');
define('DIR_APP', DIR_ROOT . 'app/');
define('DIR_PUBLIC', DIR_ROOT . 'public/');
define('DIR_STORAGE', DIR_APP . 'storage/');

require DIR_ROOT . 'vendor/autoload.php';


$config = new Configula\Config(DIR_APP . 'config/');

if ($config->getItem('app.enable_sessions', false)) {
    session_start();
}

$app = new \Slim\App($config->getItem('app', []));

// DIC configuration
$container = $app->getContainer();

//config
$container['config'] = $config;


// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Blade
$container['view'] = function ($c) use ($config) {
    $settings = $config->getItem('services.view');
    return new Blade($settings['template_path'], $settings['cache']);
};


//$container['jsonRender'] = function ($c) {
//    $view = new App\Helper\JsonRenderer();
//    return $view;
//};
//$container['jsonRequest'] = function ($c) {
//    $jsonRequest = new App\Helper\JsonRequest();
//    return $jsonRequest;
//};
//$container['notAllowedHandler'] = function ($c) {
//    return function ($request, $response, $methods) use ($c) {
//        $view = new App\Helper\JsonRenderer();
//        return $view->render($response, 405,
//            ['error_code' => 'not_allowed', 'error_message' => 'Method must be one of: ' . implode(', ', $methods)]
//        );
//    };
//};
//$container['notFoundHandler'] = function ($c) {
//    return function ($request, $response) use ($c) {
//        $view = new App\Helper\JsonRenderer();
//        return $view->render($response, 404, ['error_code' => 'not_found', 'error_message' => 'Not Found']);
//    };
//};
//
//$container['errorHandler'] = function ($c) {
//    return function ($request, $response, $exception) use ($c) {
//        $settings = $c->settings;
//        $view = new App\Helper\JsonRenderer();
//        $errorCode = 500;
//        if (is_numeric($exception->getCode()) && $exception->getCode() > 300 && $exception->getCode() < 600) {
//            $errorCode = $exception->getCode();
//        }
//        if ($settings['displayErrorDetails'] == true) {
//            $data = [
//                'error_code' => $errorCode,
//                'error_message' => $exception->getMessage(),
//                'file' => $exception->getFile(),
//                'line' => $exception->getLine(),
//                'trace' => explode("\n", $exception->getTraceAsString()),
//            ];
//        } else {
//            $data = [
//                'error_code' => $errorCode,
//                'error_message' => $exception->getMessage()
//            ];
//        }
//        return $view->render($response, $errorCode, $data);
//    };
//};

$container['csrf'] = function () {
    $guard = new \Slim\Csrf\Guard();
//    $guard->setFailureCallable(function ($request, $response, $next) {
//        $request = $request->withAttribute("csrf_status", false);
//        return $next($request, $response);
//    });
    return $guard;
};

// Flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// database
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection($config->getItem('database'));
$capsule->setAsGlobal();
$capsule->bootEloquent();


// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function () use ($config) {
    $logger = new \Monolog\Logger($config->getItem('app.name'));
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($config->getItem('logger.path'), $config->getItem('logger.level')));

    return $logger;
};


// -----------------------------------------------------------------------------
// Middleware
// -----------------------------------------------------------------------------

$app->add($container->get('csrf'));
$app->add(new \Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware);


return $app;