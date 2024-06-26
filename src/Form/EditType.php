<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',TextType::class,[
                'attr'=>[
                    'class'=>'form-input',
                    'name'=>'username'
                ]
            ])
            ->add('email', EmailType::class ,[
                'attr'=>[
                    'class'=>'form-input',
                    'name'=>'email'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Save Changes',
                'attr'=>[
                    'class'=>'form-button'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr'=>[
                'class'=>'form'
            ]
        ]);
    }
}
