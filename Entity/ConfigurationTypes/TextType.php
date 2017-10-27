<?php

namespace KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes;

use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;

class TextType extends AbstractConfigurationType
{
    public function getValue() : ?string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate() : string
    {
        return 'SonataAdminBundle:CRUD:list_string.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function generateFormField(FormMapper $formMapper) : void
    {
        $formMapper->add('value', FormTextType::class);
    }
}
