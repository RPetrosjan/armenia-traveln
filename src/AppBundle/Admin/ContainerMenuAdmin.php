<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ContainerMenuAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name', 'text')
            ->add('iconAwesome','text')
            ->add('path','text')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
       $filter
           ->add('name')
       ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('name','string');

    }
}