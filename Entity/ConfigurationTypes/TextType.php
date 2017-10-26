<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;

/**
 * @ORM\Entity(repositoryClass="KunicMarko\SonataConfigurationPanelBundle\Repository\ConfigurationRepository")
 */
class TextType extends AbstractConfiguration
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
