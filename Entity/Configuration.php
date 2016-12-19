<?php

namespace KunicMarko\ConfigurationPanelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\ConfigurationPanelBundle\Traits\TimestampableTrait;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Configuration
 *
 * @ORM\Entity(repositoryClass="KunicMarko\ConfigurationPanelBundle\Repository\ConfigurationRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("name", repositoryMethod="findByUniqueCriteria")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "text"     = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\TextType",
 *     "date"     = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\DateType",
 *     "email"    = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\EmailType",
 *     "boolean"  = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\BooleanType",
 *     "choice"   = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\ChoiceType",
 *     "color"    = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\ColorType",
 *     "html"     = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\HtmlType",
 *     "checkbox" = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\CheckboxType",
 *     "other"    = "KunicMarko\ConfigurationPanelBundle\Entity\ConfigurationTypes\TextareaType"
 * })
 */

abstract class Configuration
{
    use TimestampableTrait;
    const MetaCategory = 'Meta';
    const GeneralCategory = 'General';
    const Categories = [self::MetaCategory, self::GeneralCategory];
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

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
    private $category;

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
     * @return Configuration
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
     * @return Configuration
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

    function __toString(){

        if($this->getName()){
           return $this->getName();
        }

        return 'New Item';
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Configuration
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


    public static function getCategories(){
        return array_combine(self::Categories, self::Categories);
    }
}
