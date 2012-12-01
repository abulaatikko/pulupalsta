<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('author_name', 'text', array(
                'label' => 'Nimesi'))
            ->add('body', 'textarea', array(
                'label' => 'Kommentti'))
            ->add('safe_question', 'text', array(
                'label' => 'Turvakysymys: Mikä on Perun pääkaupunki?',
                'property_path' => false));
    }

    public function getName() {
        return 'comment';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Comment'
        ));
    }

}