<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Websites;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebsiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'attr' => [
                    'style' => 'width:100%; display:flex;flex-direction:column;',
                    'id' => 'websiteURL',
                    'placeholder' => 'https://insiteful.tn',
            ],
                'label' => 'Website URL',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'id' => 'add-website-button',
                    'class' => 'btn-blue',
                ],
                'label' => 'Add',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Websites::class,
        ]);
    }
}
