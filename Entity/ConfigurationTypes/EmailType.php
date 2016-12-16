<?php

namespace KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes;
use Doctrine\ORM\Mapping as ORM;
use KunicMarko\ConfigurationPanelBundle\Entity\Configuration;
use KunicMarko\ConfigurationPanelBundle\Traits\TemplateTrait;

 /**
 *
 * @ORM\Entity
 * 
 */
class EmailType extends Configuration implements TemplateInterface
{
    use TemplateTrait;
    private static $template = 'SonataAdminBundle:CRUD:list_email.html.twig';
}
