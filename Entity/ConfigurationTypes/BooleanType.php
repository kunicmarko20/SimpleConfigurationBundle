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
class BooleanType extends AbstractConfiguration implements TemplateInterface
{
    use TemplateTrait;
    private static $template = 'ConfigurationPanelBundle:CRUD:list_field_boolean.html.twig';

    /**
     * Get value
     *
     * @return boolean
     */
    public function getValue()
    {
        return $this->value ? true : false;
    }
}
