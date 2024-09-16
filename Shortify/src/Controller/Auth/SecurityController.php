<?php

declare(strict_types= 1);

namespace App\Controller\Auth;

use App\Form\Auth\RegisterType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    public const TEMPLATE_REGISTER = 'security/register.html.twig';
    public const TEMPLATE_FAST_LOGIN = 'security/fast_login.html.twig';
    public const TEMPLATE_LOGIN = 'security/login.html.twig';

    public function __construct(
        private UserRepository $userRepository,
        private Security $security,
    ) {}

    #[Route(path:"/register/index", name:"app_register")]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {

        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            try {
                $this->userRepository->save($user, true);
            } catch (\Exception $e) {
                $this->addFlash("error", $e->getMessage());
            }
        }
    

        return $this->render(self::TEMPLATE_REGISTER,
        [
            "form_register"=> $form,
        ]
    );
    }

    #[Route(path: '/login/index', name: 'app_login')]
    #[Route(path: '/fast-login/index', name: 'app_fast_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $routeName = $request->attributes->get('_route');

        $template = $routeName === 'app_fast_login' ? self::TEMPLATE_FAST_LOGIN : self::TEMPLATE_LOGIN;

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render($template, ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout/index', name: 'app_logout')]
    public function logout(): Response
    {
        $this->security->logout();

        return $this->redirectToRoute('app_home');
    }
}
