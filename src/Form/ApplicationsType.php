<?php

namespace App\Form;

use App\Entity\Applications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ApplicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('discordId', TextType::class, ['disabled' => true])
            ->add('steamHex')
            ->add('birth_date')
            // ->add('que1')
            ->add('answ1')
            // ->add('que2')
            ->add('answ2')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Applications::class,
        ]);
    }
}
