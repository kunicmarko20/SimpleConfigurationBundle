<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;

class ConfigurationAdminController extends CRUDController
{
    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::createAction();
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * @param int|null|string $id
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id)
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::deleteAction($id);
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function batchAction()
    {
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return parent::batchAction();
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }

    /**
     * @param null $id
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id = null)
    {
        $object = $this->admin->getSubject();
        if ($this->isGranted('ROLE_SUPER_ADMIN') || $object->getCategory() != AbstractConfiguration::META_CATEGORY) {
            return parent::editAction($id);
        }
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
