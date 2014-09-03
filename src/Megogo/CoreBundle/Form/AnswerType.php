<?php

namespace Megogo\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnswerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('iceCream')
            ->add('superhero')
            ->add('movieStar')
            ->add('worldEnd')
            ->add('worldEnd', 'date', [
                    'years'  => range(date('Y'), date('Y')+200),
                ])
            ->add('superBowl')
            ->add('user', 'entity_hidden', array(
                    'class' => 'Megogo\CoreBundle\Entity\User'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Megogo\CoreBundle\Entity\Answer'
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'megogo_corebundle_answer';
    }
}
