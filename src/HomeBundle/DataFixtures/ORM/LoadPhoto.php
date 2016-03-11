<?php
// src/HomeBundle/DataFixtures/ORM/LoadPhoto.php

namespace HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HomeBundle\Entity\Photo;

class LoadPhoto implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {

        $listPhotos = array(
            array(
                'titre'  => 'Jardin du pont',
                'description' => 'Ipsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi,',
                'url'    => 'bundles/home/images/jardin1.jpg',
                'urlmin' => 'bundles/home/images/jardin1.jpgmin'),
            array(
                'titre'  => 'Jardin Breton',
                'description' => 'Byzantiorum fuisse refertissimam atque ornatissimam signis quis ignorat? Quae illi,',
                'url'    => 'bundles/home/images/jardin2.jpg',
                'urlmin' => 'bundles/home/images/jardin2.jpgmin')
        );

        foreach ($listPhotos as $listPhoto) {
            $photo = new Photo();
            $photo->setTitre($listPhoto['titre']);
            $photo->setDescription($listPhoto['description']);
            $photo->setUrl($listPhoto['url']);
            $photo->setUrlmin($listPhoto['urlmin']);

            $manager->persist($photo);
        }

        $manager->flush();
    }
}