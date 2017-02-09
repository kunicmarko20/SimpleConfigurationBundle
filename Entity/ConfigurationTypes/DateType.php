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
class DateType extends AbstractConfiguration implements TemplateInterface
{
    use TemplateTrait;
    private static $template = 'ConfigurationPanelBundle:CRUD:list_field_date.html.twig';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * Set date
     *
     * @param \Date $date
     *
     * @return DateType
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }
}
