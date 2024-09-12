<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ShortLinkType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortLinkController extends AbstractController
{
    #[Route('/short/link', name: 'app_short_link')]
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $formShortLink = $this->createForm(ShortLinkType::class);

        $formShortLink->handleRequest($request);

        if ($formShortLink->isSubmitted() && $formShortLink->isValid()) {
            $logger->info('Your form submitted !');
        }

        return $this->render('short_link/index.html.twig', [
            'form_short_link' => $formShortLink,
        ]);
    }
}
