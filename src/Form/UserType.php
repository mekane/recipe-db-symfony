<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    //TODO: probably belongs in a service or something
    private static $roles = [
        'User' => 'ROLE_USER',
        'Admin' => 'ROLE_ADMIN'
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var User $user */
        $user = $builder->getData();

        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => self::$roles,
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('password')
        ;

        //dump($builder->getData());die();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
