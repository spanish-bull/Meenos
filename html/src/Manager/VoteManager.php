<?php


namespace App\Manager;


use App\Entity\Conference;
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


}