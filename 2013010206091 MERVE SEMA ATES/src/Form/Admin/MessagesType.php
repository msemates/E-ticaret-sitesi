<?php

namespace App\Form\Admin;

use App\Entity\Admin\Messages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('subject')
            ->add('message')
            ->add('comment')
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Messages::class,
            'csrf_protection'=>true,
        ]);
    }
}
