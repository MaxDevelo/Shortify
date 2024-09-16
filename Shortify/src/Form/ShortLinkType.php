<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\ShortLink;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Api\ShortLinkGeneratorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\User\UserInterface;

class ShortLinkType extends AbstractType
{    
    /**
     * @param ShortLinkGeneratorInterface $shortLinkGeneratorInterface
     *
     * @return void
     */
    public function __construct(
        protected ShortLinkGeneratorInterface $shortLinkGeneratorInterface,
        protected Security $security
    ) {}

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
            ->add('save', SubmitType::class, ['label' => 'Generate short link'])
            ->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit']);
    }

    public function onSubmit(FormEvent $event): void
    {
        $data = $event->getData();

        $currentUser = $this->security->getUser();

        if(!$currentUser)
        {
            return;
        }

        if ($data instanceof ShortLink) {
            $shortLink = $this->shortLinkGeneratorInterface->generate();
            $data->setShortLink($shortLink);

            $data->setCreatedAt(new \DateTimeImmutable());

            $data->setUsers($currentUser);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShortLink::class,
        ]);
    }
}
