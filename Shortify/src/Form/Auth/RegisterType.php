<?php

declare(strict_types= 1);

namespace App\Form\Auth;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterType extends AbstractType
{
    public function __construct(
        protected UserPasswordHasherInterface $userPasswordHasherInterface
        ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'required' => true,
                'options' => ['attr' => ['class' => 'password-field']],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
            ->add('save', SubmitType::class, ['label' => 'Create Your Account'])
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onSubmit']);
        ;
    }

    public function onSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $user = $event->getData();
        
        if (!$form->isValid())
        {
            return;
        }

        if (!$user->getPassword())
        {
            return;
        }

        $user->setPassword(
            $this->userPasswordHasherInterface->hashPassword($user, $user->getPassword())
        );

        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setLastedLogin(new \DateTime());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
