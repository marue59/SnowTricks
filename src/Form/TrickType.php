<?php

namespace App\Form;

use App\Entity\Trick;
use App\Form\VideoType;
use App\Form\PictureType;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class TrickType extends AbstractType
{
      /**
     * @var CategoryRepository
     */
    private $repository;

    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {  
        $categories = $this->repository->allCategories();

        $choicesCategories = [];
        foreach ($categories as $category) {
            $choicesCategories[$category->getName()]  = $category->getName();
        }

        $builder
            ->add('name', TextType::class, [
                'label' => 'Le nom de la figure'
            ])
            ->add('text', TextareaType::class, [
                'attr' => [

                ],
                'label' => 'Description'
            ])
            ->add('category', ChoiceType::class, [
                'choices' =>  $choicesCategories,
                'label' => 'Catégorie',
                'required' => false,
            ])

            ->add('picture', CollectionType::class, [
                'entry_type' => PictureType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                ]
            )
            ->add('video', CollectionType::class, [
                'entry_type' => VideoType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
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
