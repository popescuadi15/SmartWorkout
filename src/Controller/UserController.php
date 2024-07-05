<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function list(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['id' => 'DESC']);

        $user = new User();
        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }

        $updateForms = [];
        foreach ($users as $userItem) {
            $updateForms[$userItem->getId()] = $this->createForm(UserEditType::class, $userItem)->createView();
        }

        return $this->render('user/users.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }

    #[Route('/remove-user/{id}', name: 'remove_user', methods: ['POST'])]
    public function removeUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilizatorul a fost șters cu succes!');

        return $this->redirectToRoute('user_list');
    }

    #[Route('/update-user/{id}', name: 'update_user', methods: ['PATCH', 'GET', 'POST'])]
    public function updateUser(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Utilizatorul a fost actualizat cu succes!');

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
