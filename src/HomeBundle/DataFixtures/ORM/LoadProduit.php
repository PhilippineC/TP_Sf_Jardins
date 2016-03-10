<?php
// src/HomeBundle/DataFixtures/ORM/LoadProduit.php

namespace HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HomeBundle\Entity\Produit;

class LoadProduit implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {

        $listProduits = array(
            array(
                'nom'  => 'Chaise de jardin',
                'description' => 'Cette magnifique chaise assortie aux couleurs de votre jardin vous offrira de beaux moments de détente.',
                'url' => 'bundles/home/images/chair_mini.jpg',
                'alt' => 'Chaise de jardin proposée par Les Jardins d\'OpenClassrooms'),
            array(
                'nom'  => 'Système d\'arrosage',
                'description' => 'Ce système d\'arrosage vous permettra de faire pousser votre pelouse sans le moindre effort !',
                'url' => 'bundles/home/images/arrosage_mini.jpg',
                'alt' => 'Système d\'arrosage de jardin proposée par Les Jardins d\'OpenClassrooms'),
            array(
                'nom'  => 'Roue décorative',
                'description' => 'Cette roue fabriquée à partir de matériau de récupération ornera votre jardin de façon élégante.',
                'url' => 'bundles/home/images/roue_mini.jpg',
                'alt' => 'Roue décorative proposée par Les Jardins d\'OpenClassrooms'),
        );

        foreach ($listProduits as $listProduit) {
            $produit = new Produit();
            $produit->setNom($listProduit['nom']);
            $produit->setDescription($listProduit['description']);
            $produit->setUrl($listProduit['url']);
            $produit->setAlt($listProduit['alt']);
            $manager->persist($produit);
        }
        $manager->flush();
    }
}