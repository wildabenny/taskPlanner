<?php

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('startDate', DateTimeType::class, array(
                'data' => date_create('now')
            ))
            ->add('finishDate', DateTimeType::class, array(
                'data' => date_create('now')
            ))
            ->add('category', 'entity', array(
                'class' => 'AppBundle:Category',
                'property' => 'name',
                'multiple' => false
            ))
            ->add('Add Task', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task' 
        ));
    }
}