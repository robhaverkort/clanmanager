<?php

namespace ClanmanagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('facebookname')
                ->add('facebookprofile')
                ->add('save', 'submit', array('label' => 'Submit'));
    }

    public function getName() {
        return 'profile';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ClanmanagerBundle\Entity\Profile',
        ));
    }

}
