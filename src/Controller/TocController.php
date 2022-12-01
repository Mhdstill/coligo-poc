<?php

namespace App\Controller;

use App\Entity\Package;
use App\Entity\User;
use App\Form\PackageDetailsType;
use App\Form\PackageNumberType;
use App\Form\UserType;
use App\Repository\PackageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\StripeClient;
use Stripe\Checkout\Session;


class TocController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager, PackageRepository $packageRepository, Request $request): Response
    {
        $form = $this->createForm(PackageNumberType::class, new Package());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $package = $form->getData();
            $alreadExistPackage = $packageRepository->findOneBy(["reference" => $package->getReference()]);
            if($alreadExistPackage){
                $package = $alreadExistPackage;
            }

            $entityManager->persist($package);
            $entityManager->flush();

            return $this->redirectToRoute('user_details', ["packageId" => $package->getReference()]);
        }

        return $this->render("index.html.twig", ["form" => $form->createView()]);
    }

    #[Route('/{packageId}/user-details', name: 'user_details')]
    public function userDetails($packageId,Request $request, PackageRepository $packageRepository, EntityManagerInterface $entityManager): Response
    {
        $package = $packageRepository->findOneBy(["reference" => $packageId]);
        if(!$package){
            throw new \Exception('Invalid package number');
        }

        $form = $this->createForm(UserType::class, new User());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->addPackage($package);
            $entityManager->persist($package);
            $entityManager->flush();

            return $this->redirectToRoute('package_details', ["packageId" => $package->getReference()]);
        }

        return $this->render("user_details.html.twig", ["form" => $form->createView()]);
    }

    #[Route('/{packageId}/package-details', name: 'package_details')]
    public function packageDetails($packageId,Request $request, PackageRepository $packageRepository, EntityManagerInterface $entityManager): Response
    {
        $package = $packageRepository->findOneBy(["reference" => $packageId]);
        if(!$package){
            throw new \Exception('Invalid package number');
        }

        $form = $this->createForm(PackageDetailsType::class, $package);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $package = $form->getData();
            $entityManager->persist($package);
            $entityManager->flush();

            $stripe = new \Stripe\StripeClient(
                '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'
            );
            $stripeCheckout = $stripe->checkout->sessions->create([
                'success_url' => 'https://coligo.fr/success',
                'cancel_url' => 'https://coligo.fr/'.$packageId.'/package-details',
                'line_items' => [
                    [
                        'price' => 'price_1M9q54KRZ5jQkNEJtJv7vrKh',
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
            ]);

            return $this->redirect($stripeCheckout->url);
        }

        return $this->render("package_details.html.twig", ["form" => $form->createView()]);
    }

    #[Route('/success', name: 'success')]
    public function success(EntityManagerInterface $entityManager, PackageRepository $packageRepository, Request $request): Response
    {
        return $this->render("success.html.twig");
    }

}
