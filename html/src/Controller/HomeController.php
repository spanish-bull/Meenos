<?php

namespace App\Controller;

use App\Manager\ConferenceManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ConferenceManager $conferenceManager)
    {
        $conferenceManager->countNbPage();
        $pageConf =$conferenceManager->paginationHome(1);
        return $this->render('home/index.html.twig', [
            'page' => 1 ,
            'nbPage' => $conferenceManager->countNbPage(),
            'conferences' => $pageConf,
        ]);
    }
    /**
     * @Route("/{page}", name="home_page")
     */
    public function pagination(ConferenceManager $conferenceManager, $page)
    {

        $conferenceManager->countNbPage();
        $pageConf=$conferenceManager->paginationHome($page);
        return $this->render('home/index.html.twig', [
            'page' => $page,
            'nbPage' => $conferenceManager->countNbPage(),
            'conferences' => $pageConf,
        ]);
    }
}
