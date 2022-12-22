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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class CrudControler extends AbstractController
{
    #[Route('/admin', name: 'admin_login')]
     public function login(AuthenticationUtils $authenticationUtils): Response
    {
             // get the login error if there is one
             $error = $authenticationUtils->getLastAuthenticationError();

             // last username entered by the user
             $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('admin/login.html.twig', [
                           'last_username' => $lastUsername,
                           'error'         => $error,
          ]);
      }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }

    #[Route('/admin/packages', name: 'package_crud')]
    public function packages(PackageRepository $packageRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $packages = $packageRepository->findAll();

        return $this->render("admin/get_packages.html.twig", ["packages" => $packages]);
    }

    #[Route('/admin/indication', name: 'indication')]
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
