<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\Type\ExerciseType;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends AbstractController
{
    #[Route("/exercises", name: "exercise_list")]
    public function list(Request $request, EntityManagerInterface $entityManager, ExerciseRepository $exerciseRepository): Response
    {
        $exercises = $exerciseRepository->findBy([], ['id' => 'DESC']);

        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->redirectToRoute('exercise_list');
        }

        $updateForms = [];
        foreach ($exercises as $exerciseItem) {
            $updateForms[$exerciseItem->getId()] = $this->createForm(ExerciseType::class, $exerciseItem)->createView();
        }

        return $this->render('exercise/list.html.twig', [
            'exercises' => $exercises,
            'form' => $form->createView(),
            'updateForms' => $updateForms,
        ]);
    }


    #[Route("/add-exercise", name: "add_exercise")]
    public function addExercise(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();
            $entityManager->persist($exercise);
            $entityManager->flush();

            $this->addFlash('success', 'Exercitiul a fost adaugat cu succes!');

            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/addExercisePage.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route("/remove-exercise/{id}", name: "remove_exercise", methods: ["POST"])]
    public function removeExercise(Exercise $exercise, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($exercise);
        $entityManager->flush();

        $this->addFlash('success', 'Exercitiul a fost sters cu succes!');

        return $this->redirectToRoute('exercise_list');
    }

    #[Route("/update-exercise/{id}", name: "update_exercise", methods: ["PATCH", "GET", "POST"])]
    public function updateExercise(Request $request, Exercise $exercise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExerciseType::class, $exercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'Exercitiul a fost actualizat cu succes!');

            return $this->redirectToRoute('exercise_list');
        }

        return $this->render('exercise/updateExercisePage.html.twig', [
            'form' => $form->createView(),
            'exercise' => $exercise,
        ]);
    }
}
