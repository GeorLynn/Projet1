<?php
// src/AppBundle/Form/RegistrationType.php

namespace UserBundle\Form;

use FOS\UserBundle\Command\RoleCommand;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use FOS\UserBundle\FOSUserBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Role\RoleHierarchy as roles;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use Symfony\Component\Security\Core\Security;
use UserBundle\UserBundle;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('prenom')
            ->add('roles',ChoiceType::class,
            array('choices'=> array(
            'Candidat'=>'Candidat',
            'Spectateur'=>'Spectateur',
            'Admin'=>'Admin',
            'Sponsor'=>'Sponsor',
            'Jury'=>'Jury'),
            'multiple'=>true,
            'required' => true,  ))
            ->remove('username');


    }

    public function getParent()
    {

        return BaseRegistrationFormType::class;
        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }




}