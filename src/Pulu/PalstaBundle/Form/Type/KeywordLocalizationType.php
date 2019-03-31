<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Pulu\PalstaBundle\Entity\KeywordRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class KeywordLocalizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('language', HiddenType::class)
            ->add('name', TextType::class, array('label' => 'Nimi'));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\KeywordLocalization'
        ));
    }

    public function getName() {
        return 'localization';
    }
}
