<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Perk;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PerkAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dice', 'integer')
            ->add('name', 'text', array('label' => 'Name'))
            ->add('description', 'textarea', array())
            ->add('enabled', null, array('required' => false))
            ->add('type', 'choice', array('choices' => Perk::getTypeList()));
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('dice');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('dice', null, array('editable' => true))
            ->add('name', null, array('editable' => true))
            ->add('type')
            ->add(
                '_action',
                'actions',
                array(
                    'actions' => array(
                        'view' => array(),
                        'edit' => array(),
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
