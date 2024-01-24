<?php

namespace App\Controller;

use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/{token}', name: 'app_link')]
    public function index(string $token, LinkRepository $linkRepository): Response
    {
        if (!$link = $linkRepository->findOneByToken($token)) {
            return $this->redirect('https://google.com');
        }

        $link->incrementViews();

        $this->entityManager->persist($link);
        $this->entityManager->flush();

        return $this->redirect($link->getUrl());
    }
}
