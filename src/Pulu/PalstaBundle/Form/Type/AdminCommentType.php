<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminCommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('language', 'text', array(
                'label' => 'Kieli'))
            ->add('author_name', 'text', array(
                'label' => 'Kirjoittaja'))
            ->add('author_ip_address', 'text', array(
                'label' => 'IP-osoite'))
            ->add('author_user_agent', 'text', array(
                'label' => 'User-Agent'))
            ->add('account_id', 'integer', array(
                'label' => 'Käyttäjätunniste',
                'required' => false))
            ->add('body', 'textarea', array(
                'label' => 'Kommentti'));
    }

    public function getName() {
        return 'admin_comment';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Comment'
        ));
    }

}