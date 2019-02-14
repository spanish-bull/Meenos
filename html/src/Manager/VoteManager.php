<?php


namespace App\Manager;


use App\Entity\Conference;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use App\Entity\User;


class VoteManager
{
    private $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {

        $this->voteRepository = $voteRepository;

    }

    public function searchVoteByIdConference(Conference $conference)
    {

        return $this->voteRepository->findBy(['conference' => $conference]);
    }

    public function searchUserAsAlreadyVoteConference(Conference $conference, User $user)
    {
        return $this->voteRepository->findOneBy(['conference' => $conference, 'user' => $user]);
    }

    public function ratings(Conference $conference)
    {

        $qb = $this->voteRepository->createQueryBuilder('v');

        $qb->select('AVG(v.rating) as rating')
            ->addSelect('COUNT(v.id) as nmbUser')
            ->andWhere('v.conference = :conference_id')
            ->setParameter('conference_id', $conference->getId());
        $resultat = $qb->getQuery()->getResult();
        return $resultat[0];

    }

}