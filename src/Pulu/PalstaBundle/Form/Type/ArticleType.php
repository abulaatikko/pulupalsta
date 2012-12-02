<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $points = null;
        $visits = null;
        $articleNumber = null;
        if (isset($options['data'])) {
            $points = $options['data']->getPoints();
            $visits = $options['data']->getVisits();
            $articleNumber = $options['data']->getArticleNumber();
        }        
        $defaultPoints = empty($points) ? $options['default_points'] : $points;
        $defaultVisits = empty($visits) ? $options['default_visits'] : $visits;
        $defaultArticleNumber = empty($articleNumber) ? $options['default_article_number'] : $articleNumber;
        $builder
            ->add('article_number', 'integer', array(
                'label' => 'Artikkelinumero',
                'data' => $defaultArticleNumber))
            ->add('visits', 'integer', array(
                'label' => 'Vierailuja',
                'data' => $defaultVisits))
            ->add('points', 'integer', array(
                'label' => 'Pojoja', 
                'data' => $defaultPoints))
            ->add('localizations', 'collection',  array('type' => new ArticleLocalizationType()));
    }

    public function getName() {
        return 'article';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Article',
            'cascade_validation' => true,
            'default_article_number' => '1',
            'default_points' => '1',
            'default_visits' => '1'
        ));
    }

}