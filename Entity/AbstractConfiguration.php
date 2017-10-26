<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AbstractConfiguration.
 *
 * @ORM\Entity(repositoryClass="KunicMarko\SonataConfigurationPanelBundle\Repository\ConfigurationRepository")
 * @ORM\Table(name="configuration_panel")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name", repositoryMethod="findByUniqueCriteria")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "text"     = "KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes\TextType",
 *     "date"     = "KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes\DateType",
 *     "boolean"  = "KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes\BooleanType",
 *     "other"    = "KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes\TextareaType"
 * })
 */
abstract class AbstractConfiguration
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    protected $value;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->name !== null ?
            $this->name :
            'New Item';
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get template file used in sonata admin ListMapper.
     *
     * @return string
     */
    abstract public function getTemplate();

    /**
     * * Create form field for sonata create/edit form.
     *
     * @param FormMapper $formMapper
     *
     * @return void
     */
    abstract public function generateFormField(FormMapper $formMapper);
}
