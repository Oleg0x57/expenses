<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 12:08
 */

return [
    'db' => function () {
        return \ParagonIE\EasyDB\Factory::fromArray([
            'pgsql:host=localhost;port=5433;dbname=personal',
            'postgres',
            '123456'
        ]);
    },
    'MonologStreamHandler' => function () {
        $handler = new \Monolog\Handler\StreamHandler(dirname(__DIR__) . '/log/app.log', \Monolog\Logger::DEBUG);
        $handler->setFormatter(new \Monolog\Formatter\LineFormatter());
        return $handler;
    },
    'MonologRotatingFileHandler' => function () {
        $handler = new \Monolog\Handler\RotatingFileHandler(dirname(__DIR__) . '/log/app.log', 10, \Monolog\Logger::DEBUG);
        $handler->setFormatter(new \Monolog\Formatter\LineFormatter());
        return $handler;
    },
    'AppLog' => function (\Psr\Container\ContainerInterface $c) {
        $log = new \Monolog\Logger('app');
        $log->pushHandler($c->get('MonologRotatingFileHandler'));
        return $log;
    },
    'ExpendsRepository' => function (\Psr\Container\ContainerInterface $c) {
        return new \App\repositories\ExpendsRepository($c->get('db'));
    },
    'ExpendsService' => function (\Psr\Container\ContainerInterface $c) {
        return new \App\services\ExpendsService($c->get('ExpendsRepository'));
    },
    'ExpendsApiController' => function (\Psr\Container\ContainerInterface $c) {
        return new \App\api\ExpendsApiController($c->get('ExpendsService'));
    },
    'Uri' => function () {
        return new \Zend\Diactoros\Uri($_SERVER['REQUEST_URI']);
    },
    'ServerRequest' => function (\Psr\Container\ContainerInterface $c) {
        $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        return $request->withUri($c->get('Uri'));
    }
];