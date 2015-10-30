<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillsType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices' => array(
                    'gk' => 'Goalkeeper',
                    'lb' => 'Left back',
                    'cb' => 'Centre back',
                    'rb' => 'Right back',
                    'dm' => 'Defensive midfielder',
                    'lm' => 'Left midfielder',
                    'cm' => 'Centre midfielder',
                    'rm' => 'Right midfielder',
                    'am' => 'Attacking midfielder',
                    'ss' => 'Second striker',
                    'lf' => 'Left forward',
                    'cf' => 'Centre forward',
                    'rf' => 'Right forward',
                )
            )
        );
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'skills';
    }
}
