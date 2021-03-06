<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Tag;
use App\Entity\User;
use App\Form\AddConferenceType;
use App\Form\AddTagType;
use App\Form\EditConferenceType;
use App\Form\LoginUserType;
use App\Form\RegisterUserType;
use App\Manager\ConferenceManager;
use App\Manager\VoteManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $user = new User();
        $form = $this->createForm(LoginUserType::class, $user);
        return $this->render('security/login.html.twig', ['error' => $authenticationUtils->getLastAuthenticationError(), 'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/addconference", name="addConference")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addConference(Request $request)
    {
        $conference = new Conference();
        $form = $this->createForm(AddConferenceType::class,$conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Symfony\Component\HttpFoundation\File\UploadedFile $file
             */
            $file = $form->get('image')->getData();
            $fileName = $this->generateUniqueFileName().'.'.$file->guessClientExtension();
            try {
                $file->move(
                    $this->getParameter('images'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $conference->setImage($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conference);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/addconference.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/admin/addtag", name="addTag")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addTag(Request $request)
    {
        $tag = new Tag();
        $form = $this->createForm(AddTagType::class,$tag);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('security/addTag.html.twig', ['form' => $form->createView()]);

    }
    /**
     * @Route("/admin/topten", name="topten")
     */
    public function topTen(VoteManager $voteManager)
    {
        $toptenrating = $voteManager->topTenRatings();

        return $this->render('security/topten.html.twig', ['topten' => $toptenrating]);

    }
    /**
     * @Route("/admin/conference", name="admin_conference")
     */
    public function allConference(ConferenceManager $conferenceManager)
    {
        $conferences = $conferenceManager->allConference();

        return $this->render('security/conference.html.twig', ['conferences' => $conferences]);

    }
    /** * @Route("/admin/editconference/{id}", name="admin_editconference") */
    public function userEditVideo(Request $request, EntityManagerInterface $entityManager, int $id,ConferenceManager $conferenceManager)
    {
        $video = $conferenceManager->findById($id);
        $user = $this->getUser();
        $form = $this->createForm(EditConferenceType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();
            return $this->redirectToRoute('admin_conference');
        }
        return $this->render('security/editconference.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
    /** * @Route("/admin/removeconference/{id}", name="removeconference") */
    public function removeVideo(int $id, ConferenceManager $conferenceManager, EntityManagerInterface $entityManager)
    {
        $conference = $conferenceManager->findById($id);
        $entityManager->remove($conference);
        $entityManager->flush();
        return $this->redirectToRoute('admin_conference');
    }
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
