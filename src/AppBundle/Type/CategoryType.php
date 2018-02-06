<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 06/02/2018
 * Time: 13:23
 */

namespace AppBundle\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('Save',SubmitType::class)
        ;
    }

}