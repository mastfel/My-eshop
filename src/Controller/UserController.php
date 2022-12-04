<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/inscription", name="user_register", methods={"GET|POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            
            $user->setCreatedAt(new DateTime());
            $user->setUpdatedAt(new DateTime());
            
            $user->setRoles(['ROLE_USER']);

            
            $plainPassword = $form->get('password')->getData();

            
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user, $plainPassword
                )
            );

            
            $entityManager->persist($user);
            $entityManager->flush();

          
            $this->addFlash('success', 'Vous êtes inscrit avec succès !');

          
            return $this->redirectToRoute('app_login');
        } # end if()

       
        return $this->render("user/register.html.twig", [
            'form_register' => $form->createView()
        ]);
    } # end action register()
} # end class