<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortLinkController extends AbstractController
{
    #[Route('/short/link', name: 'app_short_link')]
    public function index(): Response
    {
        return $this->render('short_link/index.html.twig', [
            'controller_name' => 'ShortLinkController',
        ]);
    }
}
