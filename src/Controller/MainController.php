<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * Matches / exactly
     *
     * @Route("/", name="main_page")
     */
    public function index(): Response
    {
       return new Response(
           'Vendor is installed & file is writable. <h3>Let\'s Start!)</h3>'
       );
    }
}
