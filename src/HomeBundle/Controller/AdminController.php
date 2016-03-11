<?php

namespace HomeBundle\Controller;

use HomeBundle\Entity\Contact;
use HomeBundle\Entity\Employe;
use HomeBundle\Entity\Photo;
use HomeBundle\Entity\Produit;
use HomeBundle\Form\EmployeType;
use HomeBundle\Form\ContactType;
use HomeBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HomeBundle\Form\PhotoType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends Controller
{

    private function getEntity($route)
    {
        switch($route) {
            case 'admin_add_photo':
                $entity = new Photo();
                break;
            case 'admin_add_profil' :
                $entity = new Employe();
                break;
            case 'admin_add_produit':
                $entity = new Produit();
                 break;
            default:
                break;
        }
        return $entity;
    }

    private function getForm($entity)
    {
        switch($entity) {
            case is_a($entity, Photo::class):
                 $form = $this->createForm(PhotoType::class, $entity);
                break;
            case is_a($entity, Employe::class):
                $form = $this->createForm(EmployeType::class, $entity);
                break;
            case is_a($entity, Produit::class):
                $form = $this->createForm(ProduitType::class, $entity);
                break;
            default:
                return new Response("L'objet est invalide !");
                break;
        }
        return $form;
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addAction(Request $request)
    {
        $entity = $this->getEntity($request->get('_route'));
        $form = $this->getForm($entity);
        if ($form->handleRequest($request)->isValid()) {
            $entity->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Elément bien enregistré');
            return $this->redirectToRoute('admin');
        }

        switch ($entity)
        {
            case is_a($entity, Photo::class) :
                return $this->render('HomeBundle:Admin:add_photo.html.twig', array(
                    'form' => $form->createView(),
                ));
            case is_a($entity, Produit::class) :
                return $this->render('HomeBundle:Admin:add_produit.html.twig', array(
                    'form' => $form->createView(),
                ));
            case is_a($entity, Employe::class) :
                return $this->render('HomeBundle:Admin:add_profil.html.twig', array(
                    'form' => $form->createView(),
                ));
            default:
                return new Response("L'objet est invalide !");
                break;
        }
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */

    public function delete_photoAction(Photo $photo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($photo);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'élément a bien été supprimé.");
            return $this->redirectToRoute('admin');
        }
        return $this->render('HomeBundle:Admin:delete_photo.html.twig', array(
                    'photo' => $photo,
                    'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edit_photoAction(Photo $photo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On crée le Form grâce au service form factory
        $form = $this->createForm(PhotoType::class, $photo);

        if ($form->handleRequest($request)->isValid()) {
            $photo->upload();
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Photo bien modifiée.');
            return $this->redirectToRoute('admin');
        }

        return $this->render('HomeBundle:Admin:edit_photo.html.twig', array(
            'form' => $form->createView(),
            'photo' => $photo
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete_produitAction(Produit $produit, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($produit);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le produit a bien été supprimé.");
            return $this->redirectToRoute('admin');
        }
        return $this->render('HomeBundle:Admin:delete_produit.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edit_produitAction(Produit $produit, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProduitType::class, $produit);

        if ($form->handleRequest($request)->isValid()) {
            $produit->upload();
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Produit bien modifiée.');
            return $this->redirectToRoute('admin');
        }

        return $this->render('HomeBundle:Admin:edit_produit.html.twig', array(
            'form' => $form->createView(),
            'produit' => $produit
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete_profilAction(Employe $profil, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($profil);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le profil a bien été supprimé.");
            return $this->redirectToRoute('admin');
        }
        return $this->render('HomeBundle:Admin:delete_profil.html.twig', array(
            'profil' => $profil,
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edit_profilAction(Employe $profil, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(EmployeType::class, $profil);

        if ($form->handleRequest($request)->isValid()) {
            $profil->upload();
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Profil bien modifiée.');
            return $this->redirectToRoute('admin');
        }

        return $this->render('HomeBundle:Admin:edit_profil.html.twig', array(
            'form' => $form->createView(),
            'profil' => $profil
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete_messageAction(Contact $message, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($message);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le message a bien été supprimé.");
            return $this->redirectToRoute('admin');
        }
        return $this->render('HomeBundle:Admin:delete_message.html.twig', array(
            'message' => $message,
            'form' => $form->createView()
        ));
    }

    public function viewhomeAction(Request $request)
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

        // Génération du formulaire de contact
        $contact = new Contact();
        $contact->setDate(new \Datetime());

        // On crée le Form grâce au service form factory
        $form = $this->createForm(ContactType::class, $contact);

        return $this->render('HomeBundle:Admin:viewhome.html.twig', array(
            'listPhotos' => $listPhotos,
            'listProduits' => $listProduits,
            'listEmployes' => $listEmployes,
            'form' => $form->createView()
        ));
    }
}
