<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('author_name', 'text', array(
                'label' => 'Nimi'))
            ->add('body', 'integer', array(
                'label' => 'Kommentti'))
            ->add('bot_question', 'integer', array(
                'label' => 'Turvakysymys',
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