<?php

namespace App\Controller;

use App\Entity\Indication;
use App\Entity\Package;
use App\Entity\Shipping;
use App\Entity\User;
use App\Form\IndicationType;
use App\Form\PackageDetailsType;
use App\Form\PackageNumberType;
use App\Form\ShippingDetailsType;
use App\Form\UserType;
use App\Repository\PackageRepository;
use App\Repository\ShippingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\StripeClient;
use Stripe\Checkout\Session;


class CrudControler extends AbstractController
{
    #[Route('/admin/users', name: 'users_crud')]
    public function users(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render("get_users.html.twig", ["users" => $users]);
    }

    #[Route('/admin/packages', name: 'package_crud')]
    public function packages(PackageRepository $packageRepository): Response
    {
        $packages = $packageRepository->findAll();

        return $this->render("get_packages.html.twig", ["packages" => $packages]);
    }

    #[Route('/admin/shippings', name: 'shipping_crud')]
    public function shippings(ShippingRepository $shippingRepository): Response
    {
        $shippings = $shippingRepository->findAll();

        return $this->render("get_shippings.html.twig", ["shippings" => $shippings]);
    }

    #[Route('/indication', name: 'indication')]
    public function indication(EntityManagerInterface $entityManager, PackageRepository $packageRepository, Request $request): Response
    {
        $form = $this->createForm(IndicationType::class, new Indication());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $indication = $form->getData();
            $entityManager->persist($indication);
            $entityManager->flush();

            $this->addFlash("success","Indication créé avec succès");
        }

        return $this->render("form.html.twig", ["form" => $form->createView()]);
    }


}
