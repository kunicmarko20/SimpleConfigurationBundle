<?php

namespace KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes;
use Doctrine\ORM\Mapping as ORM;
use KunicMarko\ConfigurationPanelBundle\Entity\Configuration;
use KunicMarko\ConfigurationPanelBundle\Traits\ChoicesTrait;
/**
*
* @ORM\Entity(repositoryClass="KunicMarko\ConfigurationPanelBundle\Repository\ConfigurationRepository")
*
*/
class CheckboxType extends Configuration implements TemplateInterface
{
    use ChoicesTrait;

    public function setValue($value)
    {
        $this->value = json_encode($value);
        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return json_decode($this->value);
    }

}
