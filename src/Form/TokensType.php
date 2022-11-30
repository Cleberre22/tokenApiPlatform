<?php

namespace App\Form;

use App\Entity\Tokens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TokensType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('keyName', TextType::class, [
            'label' => 'Nom de la clé'
        ])
        // ->add('articlePermission', TextType::class, [
        //     'label' => 'Droit Article'
        // ])
        // ->add('categoryPermission', TextType::class, [
        //     'label' => 'Droit Catégorie'
        // ])
        ->add('permission', TextareaType::class, [
            'label' => 'Droit'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tokens::class,
        ]);
    }
}
