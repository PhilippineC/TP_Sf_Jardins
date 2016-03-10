<?php
// src/HomeBundle/DataFixtures/ORM/LoadContact.php

namespace HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HomeBundle\Entity\Contact;

class LoadContact implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $listContacts = array(
            array(
                'nom'  => 'Matthieu',
                'email' => 'matthieu@gmail.com',
                'message' => 'Ipsam vero urbem Byzantiorum fuisse refertissimam atque ornatissimam
                 signis quis ignorat? Quae illi, exhausti sumptibus bellisque maximis, cum omnis
                 Mithridaticos impetus totumque Pontum armatum affervescentem in Asiam atque
                 erumpentem, ore repulsum et cervicibus interclusum suis sustinerent, tum, inquam,
                 Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita
                 tenuerunt.',
                'date' => New \DateTime()),
            array(
                'nom'  => 'Alain',
                'email' => 'alain@gmail.com',
                'message' => 'Ipsam vrent, tum, inquam,
                 Byzantii et postea signa illa et reliqua urbis ornanemta sanctissime custodita
                 tenuerunt.',
                'date' => New \DateTime())
        );

        foreach ($listContacts as $listContact) {
            $contact = new Contact();
            $contact->setNom($listContact['nom']);
            $contact->setEmail($listContact['email']);
            $contact->setMessage($listContact['message']);
            $contact->setDate($listContact['date']);

            $manager->persist($contact);
        }
        $manager->flush();
    }
}