<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Module;

class ModuleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $articles = $options['articles'];
        $choices = array();
        foreach ($articles as $article) {
            $choices[$article->getId()] = $article->getName();
        }
        $builder
            ->add('article', 'entity', array(
                'class' => 'Pulu\PalstaBundle\Entity\Article',
                'property' => 'name',
                'label' => 'Artikkeli',
                'choices' => $articles))
            ->add('name', 'text', array(
                'label' => 'Nimi'
            ))
            ->add('type', 'choice', array(
                'choices' => array(
                    Module::TYPE_ADMIN_BEER_TASTING => 'admin-beer-tasting'
                ),
                'required' => true,
                'label' => 'Tyyppi'
            ));
    }

    public function getName() {
        return 'module';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Module',
            'articles' => null
        ));
    }

}