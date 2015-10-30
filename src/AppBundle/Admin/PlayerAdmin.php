<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use AppBundle\Form\Type\SkillsType;

class PlayerAdmin extends Admin
{
     /**
     * @param FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text')
            ->add(
                'team',
                'sonata_type_model_list',
                array(
                    'label' => 'Nationality',
                    'btn_add' => 'Add new Team...',
                    'btn_list' => 'Select Team...',
                    'btn_delete' => false,
                )
            )
            ->add('born', 'integer')
            ->add('skills', new SkillsType())
            ->add(
                'perks',
                'entity',
                array(
                    'class' => 'AppBundle:Perk',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'required' => false,
                )
            )
            ->add('transfermarkt', null, array('label' => 'Link to "Player data" page on Transfermarkt'))
            ->add('classic', null, array('required' => false))
            ->add('enabled', null, array('required' => false));
    }

    /**
     * @param DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('team.name')
            ->add('born')
            ->add('classic');
    }

    /**
     * @param ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name', null, array('editable' => true))
            ->add('team.name')
            ->add('born', 'integer', array('editable' => true))
            ->add('perks')
            ->add('transfermarkt', 'url')
            ->add('classic', null, array('editable' => true))
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'edit' => array(),
                        'view' => array(),
                    )
                )
            )
            ->add('enabled');
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getName();
    }
}
