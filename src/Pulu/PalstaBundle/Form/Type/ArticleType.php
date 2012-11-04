<?php

namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('visits', null, array('label' => 'Vierailuja', 'data' => '0'))
            ->add('points', null, array('label' => 'Pojoja', 'data' => '1'))
            ->add('localization', new ArticleLocalizationType(), array('label' => ' '));
    }

    public function getName() {
        return 'article';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Article',
            'cascade_validation' => true,
        ));
    }

}