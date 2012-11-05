<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Pulu\PalstaBundle\Entity\Article;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Pulu\PalstaBundle\Entity\ArticleRepository;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $points = $options['data']->getPoints();
        $articleNumber = $options['data']->getArticleNumber();
        $defaultPoints = empty($points) ? '1' : $points;
        //die(var_dump($this->translator->trans('article.name.not_blank')));
        $defaultArticleNumber = empty($articleNumber) ? $options['default_article_number'] : $articleNumber;
        $builder
            ->add('article_number', 'integer', array(
                'label' => 'Artikkelinumero',
                'invalid_message' => 'Virheellinen arvo',
                'data' => $defaultArticleNumber))
            ->add('visits', 'integer', array(
                'label' => 'Vierailuja', 
                'invalid_message' => 'Virheellinen arvo'))
            ->add('points', 'integer', array(
                'label' => 'Pojoja', 
                'invalid_message' => 'Virheellinen arvo', 
                'data' => $defaultPoints))
            ->add('localization', new ArticleLocalizationType(), array(
                'label' => ' '));
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