<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 7/11/2019
 * Time: 9:51 AM
 */

namespace App\Controllers;
use App\Services\SpamDetection;
use Psr\Container\ContainerInterface;


class HomeController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function home($request, $response, $args) {
        // your code
        // to access items in the container... $this->container->get('');
        return "<h1> Hello World! </h1>";
    }

    public function contact($request, $response, $args) {
        // your code
        // to access items in the container... $this->container->get('');
        return $response;
    }

    public function detect($request, $response, $args)
    {
        $spam = new SpamDetection();
        $score = number_format((float)$spam->detectSexBot($args['username'])*100, 2, '.', '') .'%';
        return "<h1> $score </h1>";
    }
}