<?php

namespace App\Form;

use App\Entity\Package;
use App\Entity\Shipping;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ShippingDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('disponibility', TextareaType::class,[
                'label' => 'Mes disponibilités<span style="color:red">*</span>',
                'label_html' => true,
                'label_attr' => ['class' => 'form-label text-left'],
                'attr' => ['class' => 'form-control '],
                'required' => false
            ])
            ->add('address', TextType::class,[
                'label' => 'Adresse<span style="color:red">*</span>',
                'label_html' => true,
                'label_attr' => ['class' => 'form-label text-left', 'id'=>'shipping_address'],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('complement', TextType::class,[
                'label' => 'Complément d\'adresse',
                'label_attr' => ['class' => 'form-label text-left', 'id'=>'shipping_complement'],
                'attr' => ['class' => 'form-control '],
                'required'=>false
            ])
            ->add('zip', TextType::class,[
                'label' => 'Code Postal<span style="color:red">*</span>',
                'label_html' => true,
                'label_attr' => ['class' => 'form-label text-left', 'id'=>'shipping_zip'],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville<span style="color:red">*</span>',
                'label_html' => true,
                'label_attr' => ['class' => 'form-label text-left', 'id'=>'shipping_city'],
                'attr' => ['class' => 'form-control '],
            ])
            ->add('confirm', CheckboxType::class, [
                'label'=>false,
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('submit',SubmitType::class, [
                "label"=> "Passer au paiement",
                "attr" => ["class" => "btn btn-primary btn-lg btn-block bg-orange border-orange"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shipping::class,
        ]);
    }
}
