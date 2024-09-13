<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\ShortLinkGeneratorInterface;
use App\Form\ShortLinkType;
use App\Repository\ShortLinkRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortLinkController extends AbstractController
{    
    /**
     * @param LoggerInterface $logger
     * @param ShortLinkRepository $shortLinkRepository
     * 
     * @return void
     */
    public function __construct(
        protected LoggerInterface $logger,
        protected ShortLinkRepository $shortLinkRepository,
        protected ShortLinkGeneratorInterface $shortLinkGeneratorInterface
    ) { }

    #[Route('/short/link', name: 'app_short_link')]
    public function index(Request $request): Response
    {
        $formShortLink = $this->createForm(ShortLinkType::class);

        $formShortLink->handleRequest($request);

        if ($formShortLink->isSubmitted() && $formShortLink->isValid()) {
            $this->logger->info('Your form submitted !');
            $data = $formShortLink->getData();

            $shortLink = $this->shortLinkGeneratorInterface->generate();

            dd($shortLink);
        }

        return $this->render('short_link/index.html.twig', [
            'form_short_link' => $formShortLink,
        ]);
    }
}
