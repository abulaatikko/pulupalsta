<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $safety_questions = array(
            array(
                'question' => 'Safety question: Which country has the largest population?',
                'answers' => array('kiina', 'china', 'people\'s republic of china', 'prc', 'kiinan kansantasavalta')),
            array(
                'question' => 'Safety question: What\'s the name of the nearest star to us?',
                'answers' => array('aurinko', 'sun')),
            array(
                'question' => 'Safety question: What\'s the first letter of the alphabet?',
                'answers' => array('a', 'aa')),
            array(
                'question' => 'Safety question: What\'s the first name of the creator of this site?',
                'answers' => array('lassi', 'abula', 'heikkinen', 'lassi heikkinen')),
            array(
                'question' => 'Safety question: How much is six multiplied by six?',
                'answers' => array('36', 'kolmekymmentäkuusi', 'thirty six'))
        );
        shuffle($safety_questions);

        $builder
            ->add('author_name', 'text', array(
                'label' => 'Your name',
                'data' => $options['default_author_name']))
            ->add('body', 'textarea', array(
                'label' => 'Comment',
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
