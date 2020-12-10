<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $safety_questions = array(
            /*array(
                'question' => 'The virus - what country did it start to spread from?',
                'answers' => array('kiina', 'china', 'people\'s republic of china', 'prc', 'kiinan kansantasavalta')),
            array(
                'question' => 'The star, the one quite close to us?',
                'answers' => array('aurinko', 'sun')),
            array(
                'question' => 'What\'s the first...no...second letter of the alphabet?',
                'answers' => array('b', 'b')),*/
            array(
                'question' => 'What\'s the name of this website?',
                'answers' => array('puluprojects', 'pulupalsta', 'palsta', 'pulu', 'project-z', 'project z', 'z')) // use lowercase
        );
        shuffle($safety_questions);

        $builder
            ->add('author_name', TextType::class, array(
                'label' => 'Your alias',
                'data' => $options['default_author_name']))
            ->add('author_key', PasswordType::class, array(
                'label' => 'Your key',
                'required' => false,
                'data' => $options['default_author_key']))
            ->add('body', TextareaType::class, array(
                'label' => 'Your comment',
                'data' => $options['default_body']))
            ->add('safety_question', TextType::class, array(
                'label' => $safety_questions[0]['question'],
                'mapped' => false,
                'data' => $options['default_safety_question']))
            ->add('safety_answer', HiddenType::class, array(
                'data' => base64_encode(serialize($safety_questions[0]['answers'])),
                'mapped' => false));
    }

    public function getName() {
        return 'comment';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Comment',
            'default_body' => '',
            'default_author_name' => '',
            'default_author_key' => '',
            'default_safety_question' => ''
        ));
    }

}
