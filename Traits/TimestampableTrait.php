<?php

namespace KunicMarko\ConfigurationPanelBundle\Traits;

trait TimestampableTrait
{
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

    public function setCreatedAt($datetime)
    {
        $this->createdAt = $datetime;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($datetime)
    {
        $this->updatedAt = $datetime;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
    * @ORM\PrePersist
    */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
    * @ORM\PreUpdate
    */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
