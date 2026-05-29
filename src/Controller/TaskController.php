<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_index')]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/tasks/{id}', name: 'task_details')]
    public function details(int $id, TaskRepository $taskRepository): Response
    {
        $task = $taskRepository->find($id);

        if ($task === null) {
            throw $this->createNotFoundException('Task not found.');
        }

        return $this->render('task/details.html.twig', [
            'task' => $task,
        ]);
    }
}
