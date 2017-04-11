<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataConfigurationPanelBundle\Traits\TimestampableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * AbstractConfiguration
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
    use TimestampableTrait;

    const META_CATEGORY = 'Meta';
    const GENERAL_CATEGORY = 'General';
    const CATEGORIES = [self::META_CATEGORY, self::GENERAL_CATEGORY];
    const CACHE_KEY = 'SonataConfigurationPanel';
    /**
     * @var integer
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
     * @var string
     * @Assert\Choice({"Meta", "General"})
     * @Assert\NotBlank()
     * @ORM\Column(name="category", type="string")
     */
    protected $category;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
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
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {

        if ($this->getName()) {
            return $this->getName();
        }
        return 'New Item';
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Returns categories for sonata admin form
     * @return array
     */
    public static function getCategories()
    {
        return array_combine(self::CATEGORIES, self::CATEGORIES);
    }

    /**
     * Get template file used in sonata admin ListMapper
     * @return string
     */
    abstract public function getTemplate();

    /**
     * * Create form field for sonata create/edit form
     * @param FormMapper $formMapper
     * @return void
     */
    abstract public function generateFormField(FormMapper $formMapper);
}
