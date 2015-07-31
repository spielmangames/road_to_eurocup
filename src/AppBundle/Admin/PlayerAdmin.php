<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PlayerAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Name'))
            ->add(
                'team',
                'sonata_type_model_list',
                array(
                    'btn_add' => 'add new Team...',
                    'btn_list' => 'select Team...',
                    'btn_delete' => false,
                )
            )
            ->add('born', 'integer')
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
            ->add('transfermarkt')
            ->add('classic', null, array('required' => false))
            ->add('enabled', null, array('required' => false));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('classic')
            ->add('enabled');
    }

    // Fields to be shown on lists
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
            ->add('enabled', null, array('editable' => true));
    }

    /**
     * {@inheritdoc}
     */
    public function toString($object)
    {
        return $object->getName();
    }
}
