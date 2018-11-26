<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Form;

use Core\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'empty_data' => '',
            ])
            ->add('lastname', TextType::class, [
                'empty_data' => '',
            ])
            ->add('nickname', TextType::class, [
                'empty_data' => '',
            ])
            ->add('age', IntegerType::class, [
                'empty_data' => 0,
            ])
            ->add('password', TextType::class,[
                'empty_data' => '',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => User::class,
        ]);
    }
}