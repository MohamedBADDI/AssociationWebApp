<?php

namespace AclBundle\Form;

use AclBundle\Entity\Group;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$group = new Group();

        parent::buildForm($builder, $options);
        $builder ->add('cin',TextType::class)
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
           

            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('birthdate',DateType::class,[
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => [
                        'class' => 'form-control input-inline date',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd-mm-yyyy'
                    ],
                    'html5' => false,
                ]
            )
            ->add('phone',TextType::class)
            //->add('photo', FileType::class, array('data_class'=>null,'label' => 'image : ','required' => false,'attr' => array('accept' => 'image/jpeg')))
            ->add('photo',imageType::class)
            ->add('roles', ChoiceType::class, array('attr' => array('class' => 'form-control'),
                'mapped' => false,
                'choices' => array(
                    'ROLE_ADMIN'=> 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN'=> 'ROLE_SUPER_ADMIN',
                    'ROLE_MANAGER'=> 'ROLE_MANAGER',
                    'ROLE_ASSOCIATION'=> 'ROLE_ASSOCIATION',
                    'ROLE_MEMBER' => 'ROLE_MEMBER'
                ),
                'placeholder' => 'Choose an option',
                //'placeholder' => false,
                'multiple' => false,
            ))
            //->add('roles',GroupType::class,array("data_class"=>null))
       /*->add('groups', EntityType::class, array(
        // query choices from this entity
        'class' => 'AclBundle:Group',

        // use the User.username property as the visible option string
       'choices' => $group->getRoles(),
                'mapped' => false,

        // used to render a select box, check boxes or radios
        // 'multiple' => true,
        'expanded' => true,
         'multiple'=>true,
        'data_class'=> null
    ))*/
        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AclBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'aclbundle_user';
    }


}
