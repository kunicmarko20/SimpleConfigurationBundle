<?php

namespace KunicMarko\SimpleConfigurationBundle\Entity;

use Sonata\AdminBundle\Form\FormMapper;

abstract class AbstractConfigurationType
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
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

    public function prePersist() : void
    {
        $this->createdAt = $this->updatedAt = new \DateTime();
    }

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
