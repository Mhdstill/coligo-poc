<?php

namespace App\Form;

use App\Entity\Package;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PackageDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class,[
                'label' => 'Adresse 1',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('zip', TextType::class,[
                'label' => 'Code Postal',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('emplacement', TextType::class,[
                'label' => 'Où se trouve mon colis ?',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control '],
                'required' => false
            ])
            ->add('indication', ChoiceType::class, [
                'choices' => [
                    'Lourd' => 'Lourd',
                    'Léger' => 'Léger',
                    'Fragile' => 'Fragile',
                    'Grand' => 'Grand',
                    'Petit' => 'Petit',
                    'Urgent' => 'Urgent',
                ],
                'attr' => ['class'=>'form-select form-control '],
                'label'=> 'Indiciation sur mon colis',
                'label_attr' => ['class' => 'form-label text-left'],
            ])
            ->add('disponibility', TextType::class,[
                'label' => 'Mes disponibilités',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control '],
                'required' => false
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
            'data_class' => Package::class,
        ]);
    }
}
