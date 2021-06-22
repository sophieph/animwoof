<?php
  
  
  namespace App\Controller;
  
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;


  class TestController
  {
    public function index()
    {
      dd("ça fonctionne");
    }
  
    /**
     * @Route("/test/{age<\d>?0}", name="test", methods={GET})
     *
     */
    public function test($age)
    {
//      dump($request);
      return new Response("j'ai ${age} !");
    }
  }
