<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType as FormDateType;

/**
 * @ORM\Entity(repositoryClass="KunicMarko\SonataConfigurationPanelBundle\Repository\ConfigurationRepository")
 */
class DateType extends AbstractConfiguration
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return DateType
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getValue()
    {
        return $this->getDate();
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'ConfigurationPanelBundle:CRUD:list_field_date.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function generateFormField(FormMapper $formMapper)
    {
        $formMapper->add('date', FormDateType::class, ['required' => false]);
    }
}
