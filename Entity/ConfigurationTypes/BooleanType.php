<?php

namespace KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes;

use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BooleanType extends AbstractConfigurationType
{
    public function getValue() : ?bool
    {
        return (bool) $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate() : string
    {
        return 'SimpleConfigurationBundle:CRUD:list_field_boolean.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function generateFormField(FormMapper $formMapper) : void
    {
        $formMapper->add('value', ChoiceType::class, [
            'choices' => [
                0 => 'no',
                1 => 'yes',
            ],
            'data' => (int) $this->getValue(),
        ]);
    }
}
