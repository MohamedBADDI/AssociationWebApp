<?php
/**
 * Created by PhpStorm.
 * User: achouri
 * Date: 30/04/2017
 * Time: 1:47 PM
 */

namespace AclBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {parent::buildForm($builder, $options);
        $builder


        ->add('cin',TextType::class)
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
            ->add('photo' , imageType::class);
        //->add('photo', FileType::class, array('data_class'=>null,'label' => 'image : ','required' => false,'attr' => array('accept' => 'image/jpeg')));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'my_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

}
