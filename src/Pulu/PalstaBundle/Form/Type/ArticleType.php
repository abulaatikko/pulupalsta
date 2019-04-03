<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
            ->add('article_number', IntegerType::class, array(
                'label' => 'Artikkelinumero',
                'data' => $defaultArticleNumber))
            ->add('use_translator', CheckboxType::class, array(
                'label' => 'Käännöspalvelu',
                'required' => false))
            ->add('language', ChoiceType::class, array(
                'label' => 'Kieli',
                'choices' => array(
                    'suomi' => 'fi',
                    'englanti' => 'en',
                ),
                'multiple' => false,
                'expanded' => false))
            ->add('type', ChoiceType::class, array(
                'label' => 'Tyyppi',
                'choices' => array(
                    '' => 0,
                    'Adventure' => 1,
                    'Research' => 2,
                    'Art' => 3
                ),
                'multiple' => false,
                'expanded' => false
            ))
            ->add('is_public', CheckboxType::class, array(
                'label' => 'Listoilla',
                'required' => false))
            ->add('published', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'label' => 'Julkaistu',
                'required' => false))
            ->add('modified_public', DateTimeType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'label' => 'Muokattu (julkinen)',
                'required' => false))
            ->add('access', ChoiceType::class, array(
                'label' => 'Lukuoikeus',
                'choices' => array(
                    'Ylläpitäjä' => Article::ACCESS_ADMIN,
                    'Kaverit' => Article::ACCESS_FRIEND,
                    'Kaikki' => Article::ACCESS_ALL
                ),
                'multiple' => false,
                'expanded' => false
            ))
            ->add('localizations', CollectionType::class, ['entry_type' => ArticleLocalizationType::class]);
        
        $availableKeywords = $options['available_keywords'];

        $choices = array();
        foreach ($availableKeywords as $availableKeyword) {
            $choices[$availableKeyword->getName()] = $availableKeyword->getId();
        }

        $i = 0;
        foreach ($currentKeywords as $currentKeyword) {
            $builder
                ->add('keyword_' . $i . '_id', ChoiceType::class, array(
                    'choices' => $choices,
                    'data' => $currentKeyword->getKeyword()->getId(),
                    'mapped' => false,
                    'required' => false,
                    'label' => ' '
                ))
                ->add('keyword_' . $i . '_weight', NumberType::class, array(
                    'data' => $currentKeyword->getWeight(),
                    'mapped' => false,
                    'required' => false,
                    'label' => ' '
                ));
            $i++;
        }
        // Add one empty keyword
        $builder
            ->add('keyword_' . $i . '_id', ChoiceType::class, array(
                'choices' => $choices,
                'mapped' => false,
                'required' => false,
                'label' => ' '
            ))
            ->add('keyword_' . $i . '_weight', TextType::class, array(
                'mapped' => false,
                'required' => false,
                'label' => ' '
            ));
    }

    public function getName() {
        return 'article';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Article',
            'cascade_validation' => true,
            'default_article_number' => '1',
            'available_keywords' => null,
            'precision' => 3
        ));
    }

}
