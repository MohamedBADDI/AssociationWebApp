<?php

namespace AclBundle\Form;

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
        parent::buildForm($builder, $options);
        
        $builder ->add('cin',TextType::class)
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
            ->add('photo', FileType::class, array('data_class'=>null,'label' => 'image : ','required' => false,'attr' => array('accept' => 'image/jpeg')))
            ->add('roles', ChoiceType::class, array('attr' => array('class' => 'form-control'),
                'mapped' => false,
                'choices' => array(
                    'ROLE_SUPER_ADMIN'=> 'ROLE_SUPER_ADMIN',
                    'ROLE_MANAGER'=> 'ROLE_MANAGER',
                    'ROLE_ASSOCIATION'=> 'ROLE_ASSOCIATION',
                    'ROLE_MEMBER' => 'ROLE_MEMBER'
                ),
                'multiple' => false,));

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
