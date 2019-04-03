<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Pulu\PalstaBundle\Entity\ArticleRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ArticleLocalizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('language', HiddenType::class)
            ->add('name', TextType::class, array('label' => 'Nimi'))
            ->add('teaser', TextareaType::class, array('label' => 'Houkutusteksti', 'required' => false))
            ->add('body', TextareaType::class, array('label' => 'Runko', 'required' => false));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\ArticleLocalization'
        ));
    }

    public function getName() {
        return 'localization';
    }

}
