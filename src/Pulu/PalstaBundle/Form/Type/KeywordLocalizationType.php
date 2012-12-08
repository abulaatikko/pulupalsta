<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pulu\PalstaBundle\Entity\KeywordRepository;

class KeywordLocalizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('language', 'hidden')
            ->add('name', 'text', array('label' => 'Nimi'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\KeywordLocalization'
        ));
    }

    public function getName() {
        return 'localization';
    }
}
