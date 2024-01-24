<?php

namespace App\Controller\Api;

use App\Api\ApiProblem;
use App\Dto\CreateLinkDto;
use App\Dto\FilterLinkDto;
use App\Dto\UpdateLinkDto;
use App\Entity\Link;
use App\Exception\ApiProblemException;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[Route('/api')]
class LinkController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SerializerInterface    $serializer,
    )
    {
    }

    #[Route('/links', name: 'app_api_link_create', methods: ['POST'])]
    public function create(#[MapRequestPayload] CreateLinkDto $createLinkDto): JsonResponse
    {
        try {
            $link = $this->serializer->deserialize($createLinkDto, Link::class, 'json');

            $this->entityManager->persist($link);
            $this->entityManager->flush();

            return $this->json($link, 200, [], [
                'groups' => ['read'],
            ]);
        } catch (\Exception|\PDOException|NotEncodableValueException $e) {
            throw new ApiProblemException(
                new ApiProblem(400, ApiProblem::TYPE_ERROR, $e->getMessage())
            );
        }
    }

    #[Route('/links/{token}', name: 'app_api_link_read', methods: ['GET'])]
    public function read(LinkRepository $linkRepository, #[MapRequestPayload] ?FilterLinkDto $filterLinkDto = null, string $token = null): JsonResponse
    {
        if ($token) {
            return $this->json($linkRepository->findOneByToken($token), 200, [], [
                'groups' => ['read'],
            ]);
        }

        if ($filterLinkDto) {
            $linkFilter = $this->entityManager->getFilters();

            if (!is_null($filterLinkDto->deleted)) {
                $linkFilter->enable('link_deleted')
                    ->setParameter('deleted', $filterLinkDto->deleted);
            }

            if (!is_null($filterLinkDto->views)) {
                $linkFilter->enable('link_views')
                    ->setParameter('views', $filterLinkDto->views);
            }
        }

        return $this->json($linkRepository->findAll(), 200, [], [
            'groups' => ['read'],
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/links/{token}', name: 'app_api_link_update', methods: ['PATCH'])]
    public function update(LinkRepository $linkRepository, #[MapRequestPayload] UpdateLinkDto $updateLinkDto, string $token): JsonResponse
    {
        if (!$link = $linkRepository->findOneByToken($token)) {
            throw new ApiProblemException(
                new ApiProblem(404, ApiProblem::TYPE_ERROR, 'Not found')
            );
        }

        try {
            if (!is_null($updateLinkDto->lifetime)) {
                $link->setLifetime($updateLinkDto->lifetime);
            }

            if (!is_null($updateLinkDto->url)) {
                $link->setUrl($updateLinkDto->url);
            }

            $this->entityManager->persist($link);
            $this->entityManager->flush();

            return $this->json($link, 200, [], [
                'groups' => ['read'],
            ]);
        } catch (\Exception|JsonException|ApiProblemException $e) {
            throw new ApiProblemException(
                new ApiProblem(400, ApiProblem::TYPE_ERROR, $e->getMessage())
            );
        }
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/links/{token}', name: 'app_api_link_delete', methods: ['DELETE'])]
    public function delete(string $token, LinkRepository $linkRepository): JsonResponse
    {
        if (!$link = $linkRepository->findOneByToken($token)) {
            throw new ApiProblemException(
                new ApiProblem(404, ApiProblem::TYPE_ERROR, 'Not found')
            );
        }

        try {
            $link->setDeletedAt(new \DateTimeImmutable());

            $this->entityManager->persist($link);
            $this->entityManager->flush();

            return $this->json($link, 200, [], [
                'groups' => ['read'],
            ]);
        } catch (\Exception $e) {
            throw new ApiProblemException(
                new ApiProblem(400, ApiProblem::TYPE_ERROR, $e->getMessage())
            );
        }
    }
}
