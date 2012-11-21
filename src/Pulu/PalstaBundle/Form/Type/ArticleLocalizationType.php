<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pulu\PalstaBundle\Entity\ArticleRepository;

class ArticleLocalizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('language', 'hidden')
            ->add('name', 'text', array('label' => 'Nimi'))
            ->add('teaser', 'textarea', array('label' => 'Houkutusteksti', 'required' => false))
            ->add('body', 'textarea', array('label' => 'Runko', 'required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\ArticleLocalization'
        ));
    }

    public function getName() {
        return 'localization';
    }
}
