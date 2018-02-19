<?php

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('fullname')
           ->add('username')
           ->add('password',RepeatedType::class,[
               'type' => PasswordType::class,
               'first_options'  => ['label' => 'Password'],
               'second_options' => ['label' => 'Repeat Password']
           ])
           ->add('save',SubmitType::class)
       ;
    }
}