<?php

namespace App\Manager;


use App\Repository\ConferenceRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ConferenceManager
{
    private $conferenceRepository;

    public function __construct(ConferenceRepository $conferenceRepository)
    {

        $this->conferenceRepository = $conferenceRepository;

    }

    public function countNbPage()
    {
        $qb = $this->conferenceRepository->createQueryBuilder('c');
        $qb->select('count(c)');
        $qb->getQuery()->execute();
        $nbAllConf= $qb->getQuery()->execute();
        if (!empty($nbAllConf)) {
            return ceil($nbAllConf[0][1] / 20);
        }
        return 1;
    }

    public function paginationHome($first_result, $max_results = 20)
    {
        $qb = $this->conferenceRepository->createQueryBuilder('c');

        $qb->select('(c.title) as title, (c.summary) as summary, (c.date) as date, (c.image) as image,(c.content) as content, (c.id) as id')

            ->join('c.vote', 'v')
            ->addSelect('AVG(v.rating) as rating','COUNT(v.id) as nmbUser')
            ->groupBy('c')
            ->orderBy('c.date', 'DESC')
            ->setFirstResult($first_result)
            ->setMaxResults($max_results)
        ;
        $pag = new Paginator($qb);
        return $pag->getQuery()->execute();
    }

    public function conferenceVoteNotExist()
    {
        $qb = $this->conferenceRepository->createQueryBuilder('c');
        $qb->select('(c.title) as title, (c.summary) as summary, (c.date) as date, (c.image) as image,(c.content) as content, (c.id) as id ')
            ->leftJoin('c.vote', 'v')
            ->where('v.conference is null')
            ->addSelect('AVG(v.rating) as rating','COUNT(v.id) as nmbUser')
            ->groupBy('c')
            ->orderBy('c.date', 'DESC');
        return $qb->getQuery()->execute();
    }
    public function conferenceVoteExist()
    {
        $qb = $this->conferenceRepository->createQueryBuilder('c');
        $qb->select('(c.title) as title, (c.summary) as summary, (c.date) as date, (c.image) as image,(c.content) as content, (c.id) as id ')
            ->leftJoin('c.vote', 'v')
            ->where('v.conference is not null')
            ->addSelect('AVG(v.rating) as rating','COUNT(v.id) as nmbUser')
            ->groupBy('c')
            ->orderBy('c.date', 'DESC');
        return $qb->getQuery()->execute();

    }
    public function allConference()
    {
        $qb = $this->conferenceRepository->createQueryBuilder('c');
        $qb->select('(c.title) as title, (c.summary) as summary, (c.date) as date, (c.image) as image,(c.content) as content, (c.id) as id')

            ->join('c.vote', 'v')
            ->addSelect('AVG(v.rating) as rating','COUNT(v.id) as nmbUser')
            ->groupBy('c')
            ->orderBy('c.date', 'DESC')
            ;
        return $qb->getQuery()->execute();
    }
    public function findById(int $id)
    {
        return $this->conferenceRepository->findOneBy(['id' => $id]);
    }


}