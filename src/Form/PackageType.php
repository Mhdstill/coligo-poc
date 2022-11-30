<?php

namespace App\Form;

use App\Entity\Package;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class,[
                'label' => 'Entrer votre numéro de colis',
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control form-control-lg'],
            ])
            ->add('submit',SubmitType::class, [
                "label"=> "Suivant",
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
