<?php

namespace Bubelbub\SmartHomeGUIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CentralType
 * @package Bubelbub\SmartHomeGUIBundle\Form
 * @author Bubelbub <bubelbub@gmail.com>
 */
class CentralType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('attr' => array('placeholder' => 'Name der Zentrale')))
            ->add('hostname', 'text', array('attr' => array('placeholder' => 'IP-Adresse/Hostname(:Port)')))
            ->add('username', 'text', array('attr' => array('placeholder' => 'Benutzername')))
            ->add('password', 'password', array('attr' => array('placeholder' => 'Passwort'), 'required' => $builder->getData()->getId() < 1))
            ->add('cancel', 'button', array('label' => 'Abbrechen', 'attr' => array('class' => 'btn-warning', 'data-dismiss' => 'modal', 'noCloseDiv' => true)))
            ->add('submit', 'submit', array('label' => 'Speichern', 'attr' => array('class' => 'btn-success', 'noOpenDiv' => true)))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bubelbub\SmartHomeGUIBundle\Entity\Central'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bubelbub_smarthomeguibundle_central';
    }
}
