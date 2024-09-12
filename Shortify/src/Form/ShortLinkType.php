<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\ShortLink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ShortLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('long_url', UrlType::class, [
                'label' => 'URL',
                'constraints' => [
                    new Url([
                        'message' => 'Please enter a valid URL.',
                    ])
                    ],
            ])
            ->add('expires_at', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('save', SubmitType::class, ['label' => 'Generate short link']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShortLink::class,
        ]);
    }
}
