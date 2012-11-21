<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $points = $options['data']->getPoints();
        $articleNumber = $options['data']->getArticleNumber();
        $defaultPoints = empty($points) ? '1' : $points;
        $defaultArticleNumber = empty($articleNumber) ? $options['default_article_number'] : $articleNumber;
        $builder
            ->add('article_number', 'integer', array(
                'label' => 'Artikkelinumero',
                'data' => $defaultArticleNumber))
            ->add('visits', 'integer', array(
                'label' => 'Vierailuja'))
            ->add('points', 'integer', array(
                'label' => 'Pojoja', 
                'data' => $defaultPoints))
            ->add('localizations', 'collection',  
                array(
                    'type' => new ArticleLocalizationType()
                ));
    }

    public function getName() {
        return 'article';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Article',
            'cascade_validation' => true,
            'default_article_number' => '1'
        ));
    }

}