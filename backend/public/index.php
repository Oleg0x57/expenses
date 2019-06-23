<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 12:15
 */

require dirname(__DIR__) . '/vendor/autoload.php';

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $message = '[' . $errno . '] ' . $errstr;
    throw new Exception($message);
});

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(dirname(__DIR__) . '/config/common.php');
$container = $containerBuilder->build();
$logger = $container->get('AppLog');
/** @var \Psr\Http\Message\ServerRequestInterface $request */
$request = $container->get('ServerRequest');
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute(['OPTIONS', 'GET', 'POST', 'PUT', 'DELETE'], '/api/v1/expends[/{id:\d+}]', 'expends_api');
});

$httpMethod = $request->getMethod();
$uri = $request->getUri();

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new \Zend\Diactoros\Response\JsonResponse(json_encode(['error' => '404']), 404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        $response = new \Zend\Diactoros\Response\JsonResponse(json_encode(['ALLOWED_METHODS' => $allowedMethods]), 405);
        break;
    case FastRoute\Dispatcher::FOUND:
        try {
            if ($routeInfo[1] === 'expends_api') {
                $controller = $container->get('ExpendsApiController');
                $id = null;
                $method = $request->getMethod();
                if ($method === 'PUT') {
                    $putBody = [];
                    mb_parse_str((string)$request->getBody(), $putBody);
                    $request = $request->withParsedBody($putBody);
                }
                $params = $request->getParsedBody();
                extract($routeInfo[2]);
                $result = $controller->respond($method, $id, $params);
                $response = new \Zend\Diactoros\Response\JsonResponse($result, 200);
            }
        } catch (Throwable $exception) {
            $result = json_encode(['error' => $exception->getMessage()]);
            $response = new \Zend\Diactoros\Response\JsonResponse($result, 500);
        }
        break;
}

if (!headers_sent()) {
    header('access-control-allow-origin: *');
    foreach ($response->getHeaders() as $name => $value) {
        header($name . ': ' . implode(',', $value));
    }
}
header(sprintf(
    'HTTP/%s %s %s',
    $response->getProtocolVersion(),
    $response->getStatusCode(),
    $response->getReasonPhrase()
), true, $response->getStatusCode());
echo $response->getBody();
