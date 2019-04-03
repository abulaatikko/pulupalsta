<?php
namespace Pulu\PalstaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AdminCommentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('language', TextType::class, array(
                'label' => 'Kieli'))
            ->add('author_name', TextType::class, array(
                'label' => 'Kirjoittaja'))
            ->add('author_ip_address', TextType::class, array(
                'label' => 'IP-osoite'))
            ->add('author_user_agent', TextType::class, array(
                'label' => 'User-Agent'))
            ->add('account_id', IntegerType::class, array(
                'label' => 'Käyttäjätunniste',
                'required' => false))
            ->add('body', TextareaType::class, array(
                'label' => 'Kommentti'));
    }

    public function getName() {
        return 'admin_comment';
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Pulu\PalstaBundle\Entity\Comment'
        ));
    }

}
