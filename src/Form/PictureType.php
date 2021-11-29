<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
        ->add(
            'path', FileType::class,
            [
            'constraints' => [
                new Image(
                    [
                    'maxWidth' => $options['width'],
                    'maxHeight' => $options['height'],
                    ]
                ),
            ],
            ]
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
            'width' => 400,
            'height' => 400,
        ]);
    }
}
