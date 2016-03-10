<?php
// src/HomeBundle/DataFixtures/ORM/LoadEmploye.php

namespace HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HomeBundle\Entity\Employe;

class LoadEmploye implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {

        $listEmployes = array(
            array(
                'nom'  => 'Kevin',
                'metier' => 'paysagiste',
                'biographie' => 'Kévin est spécialiste de l\'aménagement des allées : sinueuse et longiligne.',
                'twitter'    => 'http://www.Twitter.com/Kevin',
                'facebook' => 'http://www.facebook.com/Kevin',
                'linkedin' => 'http://www.linkedin.com/Kevin',
                'photo' => 'bundles/home/images/kevin.jpg'),
            array(
                'nom'  => 'Brandon',
                'metier' => 'paysagiste',
                'biographie' => 'Brandon est spécialiste de l\'aménagement des espaces aquatiques : lacs, étangs, etc.',
                'twitter'    => 'http://www.Twitter.com/Brandon',
                'facebook' => 'http://www.facebook.com/Brandon',
                'linkedin' => 'http://www.linkedin.com/Brandon',
                'photo' => 'bundles/home/images/brandon.jpg'),
            array(
                'nom'  => 'Dylan',
                'metier' => 'paysagiste',
                'biographie' => 'Dylan est spécialiste du gazon. Il donnera une belle couleur verte flamboyante à votre pelouse.',
                'twitter'    => 'http://www.Twitter.com/Dylan',
                'facebook' => 'http://www.facebook.com/Dylan',
                'linkedin' => 'http://www.linkedin.com/Dylan',
                'photo' => 'bundles/home/images/dylan.jpg'),
            array(
                'nom'  => 'Joey',
                'metier' => 'paysagiste',
                'biographie' => 'Joey est spécialiste des connifères. Originaire des Vosges, il saura vous guider.',
                'twitter'    => 'http://www.Twitter.com/Joey',
                'facebook' => 'http://www.facebook.com/Joey',
                'linkedin' => 'http://www.linkedin.com/Joey',
                'photo' => 'bundles/home/images/joey.png')
        );

        foreach ($listEmployes as $listEmploye) {
            $employe = new Employe();
            $employe->setNom($listEmploye['nom']);
            $employe->setMetier($listEmploye['metier']);
            $employe->setBiographie($listEmploye['biographie']);
            $employe->setTwitter($listEmploye['twitter']);
            $employe->setFacebook($listEmploye['facebook']);
            $employe->setLinkedin($listEmploye['linkedin']);
            $employe->setPhoto($listEmploye['photo']);

            $manager->persist($employe);
        }
        $manager->flush();
    }
}