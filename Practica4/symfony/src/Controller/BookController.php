<?php

namespace App\Controller;

use Psr\Log\AbstractLogger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController {

    /** @Route("/book/listHello", name="book_listHello") */
    public function listHello() {
        $response = new Response();
        $response->setContent('<div>Hola mubdo</div>');
        return $response;}
    }