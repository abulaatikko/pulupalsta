<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Module;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ModuleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $articles = $options['articles'];
        $choices = array();
        foreach ($articles as $article) {
            $choices[$article->getName()] = $article->getId();
        }
        $builder
            ->add('article', EntityType::class, array(
                'class' => 'Pulu\PalstaBundle\Entity\Article',
                'choice_label' => 'name',
                'label' => 'Artikkeli',
                'choices' => $articles))
            ->add('name', TextType::class, array(
                'label' => 'Nimi'
            ))
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'admin-beer-tasting' => Module::TYPE_ADMIN_BEER_TASTING,
                    'admin-municipality' => Module::TYPE_ADMIN_MUNICIPALITY,
                ),
                'required' => true,
                'label' => 'Tyyppi'
            ));
    }

    public function getName() {
        return 'module';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Module',
            'articles' => null
        ));
    }

}
