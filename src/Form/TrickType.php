<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [

                ],
                'label' => 'Votre nom'
            ])
            ->add('text', TextareaType::class, [
                'attr' => [

                ],
                'label' => 'Description'
            ])
            ->add('category', EntityType::class, [
                'choice_label' => 'name',
                'class' =>  Category::class,
                'label' => 'Indiquez la catégorie'
            ])
            ->add(
                'picture',
                CollectionType::class,
                [
                'label' => 'Importez vos images',
                'entry_type' => PictureType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                ]
            )
            ->add(
                'video',
                CollectionType::class,
                [
                'label' => 'Importez vos video',
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
