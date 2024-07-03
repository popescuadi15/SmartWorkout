<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\User;
use App\Form\Type\ExerciseType;
use App\Form\Type\UserType;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route("/sign-up", name: "sign_up")]
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
