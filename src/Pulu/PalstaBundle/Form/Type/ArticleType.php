<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                'label' => 'Käytä automaattista käännöstä',
                'required' => false))
            ->add('is_public', 'checkbox', array(
                'label' => 'Julkinen',
                'required' => false))
            ->add('published', 'datetime', array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'label' => 'Julkaistu',
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
