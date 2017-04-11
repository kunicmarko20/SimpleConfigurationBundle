<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
*
* @ORM\Entity(repositoryClass="KunicMarko\SonataConfigurationPanelBundle\Repository\ConfigurationRepository")
*
*/
class BooleanType extends AbstractConfiguration
{

    /**
     * Get value
     *
     * @return boolean
     */
    public function getValue()
    {
        return $this->value ? true : false;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate()
    {
        return 'ConfigurationPanelBundle:CRUD:list_field_boolean.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function generateFormField(FormMapper $formMapper)
    {
        $formMapper->add('value', ChoiceType::class, [
            'required' => false,
            'choices' => [
                0 => 'no',
                1 => 'yes'
            ],
            'data' => (int) $this->getValue()
        ]);
    }
}
