<?php

namespace KunicMarko\SimpleConfigurationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AbstractConfigurationType.
 *
 * @ORM\Entity(repositoryClass="KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository")
 * @ORM\Table(name="simple_configuration")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name", repositoryMethod="findByUniqueCriteria")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "text"     = "KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes\TextType",
 *     "date"     = "KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes\DateType",
 *     "boolean"  = "KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes\BooleanType",
 *     "other"    = "KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes\TextareaType"
 * })
 */
abstract class AbstractConfigurationType
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
     *
     * @Assert\NotNull()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(name="value", type="text")
     */
    protected $value;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setValue($value) : self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getCreatedAt() : ?\DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt() : ?\DateTime
    {
        return $this->updatedAt;
    }

    public function __toString() : string
    {
        return $this->name ?? 'New Item';
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() : void
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() : void
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get template file used in sonata admin ListMapper.
     */
    abstract public function getTemplate() : string;

    /**
     * Create form field for sonata create/edit form.
     */
    abstract public function generateFormField(FormMapper $formMapper) : void;
}
