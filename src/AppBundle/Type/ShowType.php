<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 05/02/2018
 * Time: 16:11
 */

namespace AppBundle\Type;

use AppBundle\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class ShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('categories',EntityType::class, [
                'class'=> Categories::class,
                'choice_label'=>'name',
                ])
            ->add('abstract')
            ->add('country',CountryType::class)
            ->add('author')
            ->add('date')
            ->add('image',FileType::class);
    }
}