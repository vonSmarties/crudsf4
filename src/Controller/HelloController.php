<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class HelloController extends Controller {

  public function index(){
    return new Response($this->renderView('hello/hello.html.twig'));
  }
}
