<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Conference;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/conference/{id}", name="conference_page")
     * @param Conference $conference
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Conference $conference)
    {
        return $this->render('conference/index.html.twig', [
            'conference' => $conference,
        ]);
    }
}
