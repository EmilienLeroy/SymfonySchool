<?php

namespace AppBundle\Type;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
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
           ->add('roles')
           ->add('save',SubmitType::class)
       ;

       $builder->get('roles')
           ->addModelTransformer(
               new CallbackTransformer(
                   function ($roleAsArray){
                       if(!empty($roleAsArray)){
                           return implode(', ',$roleAsArray);
                       }
                   },
                   function ($rolesAsString){
                       return explode(', ', $rolesAsString);
                   }
               )
           )
       ;
    }
}