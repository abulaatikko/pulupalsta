<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use \Pulu\PalstaBundle\Entity\Article;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $articleNumber = null;
        $currentKeywords = array();
        if (isset($options['data'])) {
            $articleNumber = $options['data']->getArticleNumber();
            $currentKeywords = $options['data']->getKeywords();
        }        
        $defaultArticleNumber = empty($articleNumber) ? $options['default_article_number'] : $articleNumber;
        $builder
            ->add('article_number', 'integer', array(
                'label' => 'Artikkelinumero',
                'data' => $defaultArticleNumber))
            ->add('use_translator', 'checkbox', array(
                'label' => 'Käännöspalvelu',
                'required' => false))
            ->add('language', 'choice', array(
                'label' => 'Kieli',
                'choices' => array(
                    'fi' => 'suomi',
                    'en' => 'englanti',
                ),
                'multiple' => false,
                'expanded' => false))
            ->add('type', 'choice', array(
                'label' => 'Tyyppi',
                'choices' => array(
                    0 => '',
                    1 => 'Adventure',
                    2 => 'Research'
                ),
                'multiple' => false,
                'expanded' => false
            ))
            ->add('is_public', 'checkbox', array(
                'label' => 'Listoilla',
                'required' => false))
            ->add('published', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'label' => 'Julkaistu',
                'required' => false))
            ->add('modified_public', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'label' => 'Muokattu (julkinen)',
                'required' => false))
            ->add('access', 'choice', array(
                'label' => 'Lukuoikeus',
                'choices' => array(
                    Article::ACCESS_ADMIN => 'Ylläpitäjä',
                    Article::ACCESS_FRIEND => 'Kaverit',
                    Article::ACCESS_ALL => 'Kaikki'
                ),
                'multiple' => false,
                'expanded' => false
            ))
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
                    'mapped' => false,
                    'required' => false,
                    'label' => ' '
                ))
                ->add('keyword_' . $i . '_weight', 'number', array(
                    'data' => $currentKeyword->getWeight(),
                    'mapped' => false,
                    'required' => false,
                    'label' => ' '
                ));
            $i++;
        }
        // Add one empty keyword
        $builder
            ->add('keyword_' . $i . '_id', 'choice', array(
                'choices' => $choices,
                'mapped' => false,
                'required' => false,
                'label' => ' '
            ))
            ->add('keyword_' . $i . '_weight', 'text', array(
                'mapped' => false,
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
            'available_keywords' => null,
            'precision' => 3
        ));
    }

}
