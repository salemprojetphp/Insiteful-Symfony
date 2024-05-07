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
//        $user=$options['user'];
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
            ])
//            ->add('oldPassword', PasswordType::class, [
//                'mapped' => false,
//                'label' => 'Old password',
//                'attr'=>[
//                    'class'=>'form-input',
//                    'name'=>'old-password'
//                ]
//            ])
//            ->add('newPassword', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'mapped' => false,
//                'label' => 'New password',
//                'required' => false,
//                'first_options'  => ['label' => 'New password'],
//                'second_options' => ['label' => 'Repeat password'],
//                'attr'=>[
//                    'class'=>'form-input',
//                    'name'=>'new-password'
//                ]
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('user');
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr'=>[
                'class'=>'form'
            ]
        ]);
    }
}
