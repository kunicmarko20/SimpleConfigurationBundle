<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConfigurationRepository extends EntityRepository
{
    /**
     * @param string[] $criteria format: array('name' => <name>)
     *
     * @return \KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration
     */
    public function findByUniqueCriteria(array $criteria)
    {
        return $this->_em->getRepository('ConfigurationPanelBundle:AbstractConfiguration')->findBy($criteria);
    }
}
