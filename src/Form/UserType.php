<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Prénom',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('address', TextType::class,[
                'label' => 'Adresse',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('phone', TextType::class,[
                'label' => 'Numéro de téléphone',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('comment', TextareaType::class,[
                'label' => 'Commentaire',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('submit',SubmitType::class, [
                "label"=> "Valider",
                "attr" => ["class" => "btn btn-primary btn-lg btn-block bg-orange border-orange"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
