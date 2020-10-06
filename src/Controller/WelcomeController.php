<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PromoCodes.
 */
class WelcomeController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(): Response
    {
        return new Response('Welcome to promo codes service');
    }
}
