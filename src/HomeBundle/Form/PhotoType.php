<?php

namespace HomeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('file', FileType::class)
            ->add('enregistrer', SubmitType::class, array(
                'attr' => array('class' => 'save')))

            // On ajoute une fonction qui va écouter un évènement
            ->addEventListener(
                FormEvents::PRE_SET_DATA,    // 1er argument : L'évènement qui nous intéresse : ici, PRE_SET_DATA
                function(FormEvent $event)
                { // 2e argument : La fonction à exécuter lorsque l'évènement est déclenché
                    // On récupère notre objet Photo sous-jacent
                    $form = $event->getForm();
                    $photo = $event->getData();
                    if (!($photo->getId() == null)) // cas du formulaire de modification d'une photo
                    {
                        $form->add('file', FileType::class, array( 'required' => false));
                    }
                }
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HomeBundle\Entity\Photo'
        ));
    }
}
