<?php

namespace KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\ConfigurationPanelBundle\Entity\AbstractConfiguration;
use KunicMarko\ConfigurationPanelBundle\Traits\TemplateTrait;

/**
*
* @ORM\Entity(repositoryClass="KunicMarko\ConfigurationPanelBundle\Repository\ConfigurationRepository")
*
*/
class EmailType extends AbstractConfiguration implements TemplateInterface
{
    use TemplateTrait;
    private static $template = 'SonataAdminBundle:CRUD:list_email.html.twig';
}
