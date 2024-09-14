<?php

declare(strict_types= 1);

namespace App\Form;

use DateTime;
use App\Entity\User;
use DateTimeImmutable;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit'])
        ;
    }

    public function onSubmit(FormEvent $event): void
    {
        $user = $event->getData();

        if ($user instanceof User) {
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setLastedLogin(new DateTime('d-m-Y H:i:s'));

        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
