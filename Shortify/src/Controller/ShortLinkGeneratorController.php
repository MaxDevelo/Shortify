<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ShortLinkType;
use App\Repository\ShortLinkRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortLinkGeneratorController extends AbstractController
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
        protected Security $security,
    ) { }

    #[Route('/short/link', name: 'app_short_link')]
    public function index(Request $request): Response
    {
        if(!$this->security->getUser())
        {
            return $this->redirectToRoute('app_login');
        }

        $formShortLink = $this->createForm(ShortLinkType::class);

        $formShortLink->handleRequest($request);

        if ($formShortLink->isSubmitted() && $formShortLink->isValid()) {
            $this->logger->info('Your form submitted !');
            
            $data = $formShortLink->getData();
            
            $this->shortLinkRepository->save($data, true);

            return $this->redirectToRoute('app_short_link');
        }

        return $this->render('short_link/index.html.twig', [
            'form_short_link' => $formShortLink,
        ]);
    }
}
