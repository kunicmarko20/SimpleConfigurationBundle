<?php

namespace KunicMarko\ConfigurationPanelBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use KunicMarko\ConfigurationPanelBundle\Entity\AbstractConfiguration;

class ConfigurationAdminController extends CRUDController
{
    
    public function createAction()
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::createAction();
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    public function deleteAction($id)
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::deleteAction($id);
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    public function batchAction()
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::batchAction();
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
    public function editAction($id = null)
    {
        $object = $this->admin->getSubject();
        if ($this->isGranted('ROLE_SUPER_ADMIN') || $object->getCategory() != AbstractConfiguration::META_CATEGORY) {
            return parent::editAction($id);
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
