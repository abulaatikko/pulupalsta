<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $rating = null;
        $visits = null;
        $articleNumber = null;
        $currentKeywords = array();
        if (isset($options['data'])) {
            $rating = $options['data']->getRating();
            $visits = $options['data']->getVisits();
            $articleNumber = $options['data']->getArticleNumber();
            $currentKeywords = $options['data']->getKeywords();
        }        
        $defaultRating = empty($rating) ? $options['default_rating'] : $rating;
        $defaultVisits = empty($visits) ? $options['default_visits'] : $visits;
        $defaultArticleNumber = empty($articleNumber) ? $options['default_article_number'] : $articleNumber;
        $builder
            ->add('article_number', 'integer', array(
                'label' => 'Artikkelinumero',
                'data' => $defaultArticleNumber))
            ->add('visits', 'integer', array(
                'label' => 'Vierailuja',
                'data' => $defaultVisits))
            ->add('rating', 'integer', array(
                'label' => 'Arvosana', 
                'data' => $defaultRating))
            ->add('use_translator', 'checkbox', array(
                'label' => 'Käytä automaattista käännöstä',
                'required' => false))
            ->add('is_public', 'checkbox', array(
                'label' => 'Julkinen',
                'required' => false))
            ->add('localizations', 'collection',  array('type' => new ArticleLocalizationType()));
        
        $availableKeywords = $options['available_keywords'];

        $choices = array();
        foreach ($availableKeywords as $availableKeyword) {
            $choices[$availableKeyword->getId()] = $availableKeyword->getName();
        }

        $i = 0;
        foreach ($currentKeywords as $currentKeyword) {
            $builder
                ->add('keyword_' . $i . '_id', 'choice', array(
                    'choices' => $choices,
                    'data' => $currentKeyword->getKeyword()->getId(),
                    'property_path' => false,
                    'required' => false,
                    'label' => ' '
                ))
                ->add('keyword_' . $i . '_weight', 'number', array(
                    'data' => $currentKeyword->getWeight(),
                    'property_path' => false,
                    'required' => false,
                    'label' => ' '
                ));
            $i++;
        }
        // Add one empty keyword
        $builder
            ->add('keyword_' . $i . '_id', 'choice', array(
                'choices' => $choices,
                'property_path' => false,
                'required' => false,
                'label' => ' '
            ))
            ->add('keyword_' . $i . '_weight', 'text', array(
                'property_path' => false,
                'required' => false,
                'label' => ' '
            ));
    }

    public function getName() {
        return 'article';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Article',
            'cascade_validation' => true,
            'default_article_number' => '1',
            'default_rating' => '1',
            'default_visits' => '1',
            'available_keywords' => null,
            'precision' => 3
        ));
    }

}