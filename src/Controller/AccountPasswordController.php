<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager= $entityManager;
    }

    #[Route('/compte/modifier-mot-de-passe', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;

        $user = $this->getUser();
        $changePasswordForm = $this->createForm(ChangePasswordType::class, $user);

        $changePasswordForm->handleRequest($request);

        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $oldPassword = $changePasswordForm->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $oldPassword )) {
                $newPassword = $changePasswordForm->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $newPassword);

                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = 'Votre mot de passe a bien été mis à jours';
            } else {
                $notification = 'Votre mot de passe ne correspond pas, veuillez réessayer';
            }
        }


        return $this->render('account/password.html.twig', [
            'changePasswordForm' => $changePasswordForm->createView(),
            'notification'=> $notification
        ]);
    }
}
