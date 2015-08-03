<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use AppBundle\Entity\Perk;

class PerkAdmin extends Admin
{
    /**
     * @param FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dice', 'integer', array('label' => 'Dices value'))
            ->add('name', 'text')
            ->add('description', 'textarea', array())
            ->add('type', 'choice', array('choices' => Perk::getTypeList()))
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
            ->add('dice')
            ->add('name')
            ->add('type');
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
