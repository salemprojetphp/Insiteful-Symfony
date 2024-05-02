<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'ml32 title-input',
                    'placeholder' => 'Title', 
                    'name' => 'title',               
                ],
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Content',
                'attr' => [
                    'class' => 'ml32 content-input',
                    'placeholder' => 'Content...',
                    'name' => 'content',
                ],
                'required' => true,
            ])
            ->add('bgColor1', ColorType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'ml32 bg-color-input',
                    'name' => 'bg-color1'
                ],
                'data' => '#00ffff',
            ])
            ->add('bgColor2', ColorType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'ml32 bg-color-input',
                    'name' => 'bg-color2'
                ],
                'data' => '#147efb',
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'attr' => ['class' => 'image-input ml32'],
                'required' => false, 
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add',
                'attr' => ['class' => 'btn-blue'],
            ]);
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'attr' => [
                'class' => 'add-post-form gradient-white flex',
            ]
        ]);
    }
}
