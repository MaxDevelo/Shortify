<?php

namespace App\Form;

use App\Entity\ShortLink;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShortLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('long_url')
            ->add('short_link')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('expires_at', null, [
                'widget' => 'single_text',
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShortLink::class,
        ]);
    }
}
