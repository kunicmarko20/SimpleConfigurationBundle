<?php

namespace KunicMarko\SimpleConfigurationBundle\Entity\ConfigurationTypes;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;

/**
 * @ORM\Entity(repositoryClass="KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository")
 */
class TextType extends AbstractConfigurationType
{
    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'SonataAdminBundle:CRUD:list_string.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function generateFormField(FormMapper $formMapper)
    {
        $formMapper->add('value', FormTextType::class, ['required' => false]);
    }
}
