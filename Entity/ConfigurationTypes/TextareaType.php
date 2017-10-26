<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Entity\ConfigurationTypes;

use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType as FormTextAreaType;

/**
 * @ORM\Entity(repositoryClass="KunicMarko\SonataConfigurationPanelBundle\Repository\ConfigurationRepository")
 */
class TextareaType extends AbstractConfiguration
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
        $formMapper->add('value', FormTextAreaType::class, ['required' => false]);
    }
}
