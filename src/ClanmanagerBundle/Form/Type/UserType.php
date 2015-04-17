<?php

namespace ClanmanagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'text',array('disabled'=>true))
                ->add('email', 'text',array('disabled'=>true))
                ->add('isActive', 'checkbox',array('disabled'=>true))
                ->add('plainPassword', 'password',array('mapped'=>false))
                ->add('plainPassword2', 'password',array('mapped'=>false))
                ->add('save', 'submit', array('label' => 'Submit'));
    }

    public function getName() {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ClanmanagerBundle\Entity\User',
        ));
    }

}
