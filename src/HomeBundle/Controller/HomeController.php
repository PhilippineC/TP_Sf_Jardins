<?php

namespace HomeBundle\Controller;

use HomeBundle\Entity\Admin;
use HomeBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use HomeBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class HomeController extends Controller
{
    /**
     * @Route("/")
     */

  public function homeAction(Request $request)
    {
        // Si le visiteur est identifié, on le redirige vers la page admin
        if (true === $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('admin');

        }
        $helper = $this->get('security.authentication_utils');

        $em = $this->getDoctrine()->getManager();
        $listPhotos = $em
            ->getRepository('HomeBundle:Photo')
            ->findAll();

        $listProduits = $em
            ->getRepository('HomeBundle:Produit')
            ->findAll();

        $listEmployes = $em
            ->getRepository('HomeBundle:Employe')
            ->findAll();

        // Génération du formulaire de contact
        $contact = new Contact();
        $contact->setDate(new \Datetime());

        // On crée le Form grâce au service form factory
        $form = $this->createForm(ContactType::class, $contact);
        // On vérifie que les valeurs entrées sont correctes
        if ($form->handleRequest($request)->isValid()) {
            $em->persist($contact);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Formulaire bien envoyé');
        }

        return $this->render('HomeBundle:Home:home.html.twig', array(
            'listPhotos' => $listPhotos,
            'listProduits' => $listProduits,
            'listEmployes' => $listEmployes,
            'form' => $form->createView(),
            'error' => $helper->getLastAuthenticationError()
        ));
    }

    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listPhotos = $em
            ->getRepository('HomeBundle:Photo')
            ->findAll();

        $listProduits = $em
            ->getRepository('HomeBundle:Produit')
            ->findAll();

        $listEmployes = $em
            ->getRepository('HomeBundle:Employe')
            ->findAll();

        $listMessages = $em
            ->getRepository('HomeBundle:Contact')
            ->findAll();

        return $this->render('HomeBundle:Admin:admin.html.twig', array(
            'listPhotos' => $listPhotos,
            'listProduits' => $listProduits,
            'listEmployes' => $listEmployes,
           'listMessages' =>$listMessages
        ));
    }

}
