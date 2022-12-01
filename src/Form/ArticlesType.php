<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Tokens;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article'
            ])
            ->add('content', TextType::class, [
                'label' => 'Contenu de l\'article'
            ])
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'label' => 'Catégorie de l\'article',
            ])
            // ->add('tokens', EntityType::class, [
            //     'class' => Tokens::class,
            //     'choice_label' => 'keyName',
            //     'label' => 'Clé',
            // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
