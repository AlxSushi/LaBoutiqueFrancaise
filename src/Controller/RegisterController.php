<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Valid;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager= $entityManager;
    }


    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response {

       $user = new User();
       $registerform = $this->createForm(RegisterType::class, $user);

       $registerform->handleRequest($request);

       if ($registerform->isSubmitted() && $registerform->isValid()) {

           $user = $registerform->getData();
           $password = $encoder->hashPassword($user, $user->getPassword());

           $user->setPassword($password);

           $this->entityManager->persist($user);
           $this->entityManager->flush();
       }

        return $this->render('register/index.html.twig', [
            'registerform' => $registerform->createView()
        ]);
    }
}
