<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignUpController extends AbstractController
{
    #[Route("/sign-up", name: "sign_up", methods: ["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {


        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('sign_up');
        }

        return $this->render('auth/signup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}