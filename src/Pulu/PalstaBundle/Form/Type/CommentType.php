<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $safety_questions = array(
            array(
                'question' => 'Turvakysymys: Mikä on maailman väkirikkain valtio?',
                'answers' => array('kiina', 'china', 'people\'s republic of china', 'prc', 'kiinan kansantasavalta')),
            array(
                'question' => 'Turvakysymys: Mikä on nimeltään lähin tähtemme?',
                'answers' => array('aurinko', 'sun')),
            array(
                'question' => 'Turvakysymys: Mikä on aakkosten ensimmäinen kirjain?',
                'answers' => array('a', 'aa')),
            array(
                'question' => 'Turvakysymys: Mikä on tämän sivuston tekijän etunimi?',
                'answers' => array('lassi', 'abula', 'heikkinen', 'lassi heikkinen')),
            array(
                'question' => 'Turvakysymys: Paljonko on kuusi kertaa kuusi?',
                'answers' => array('36', 'kolmekymmentäkuusi', 'thirty six'))
        );
        shuffle($safety_questions);

        $builder
            ->add('author_name', 'text', array(
                'label' => 'Nimesi',
                'data' => $options['default_author_name']))
            ->add('body', 'textarea', array(
                'label' => 'Kommentti',
                'data' => $options['default_body']))
            ->add('safety_question', 'text', array(
                'label' => $safety_questions[0]['question'],
                'mapped' => false,
                'data' => $options['default_safety_question']))
            ->add('safety_answer', 'hidden', array(
                'data' => base64_encode(serialize($safety_questions[0]['answers'])),
                'mapped' => false));
    }

    public function getName() {
        return 'comment';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Comment',
            'default_body' => '',
            'default_author_name' => '',
            'default_safety_question' => ''
        ));
    }

}