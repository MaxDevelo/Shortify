<?php

declare(strict_types= 1);

namespace App\Controller\Redirect;

use App\Repository\ShortLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortLinkController extends AbstractController
{    
    /**
     * @param ShortLinkRepository $shortLinkRepository
     * @return void
     */
    public function __construct (
        private ShortLinkRepository $shortLinkRepository
    ) {}

    #[Route('/{shortLink}', name: 'app_redirect_short_link')]
    public function index(string $shortLink): Response
    {
        $shortLink = $this->shortLinkRepository->verifyShortLinkExists('/' . $shortLink);

        if(!$shortLink) {
         return $this->redirectToRoute('app_home');
        }

        return $this->render('short_link/redirect/index.html.twig', [
            'url' => $shortLink->getLongUrl(),
        ]);
    }
}
