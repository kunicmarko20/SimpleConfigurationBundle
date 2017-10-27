<?php

namespace KunicMarko\SimpleConfigurationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;

class ConfigurationRepository extends EntityRepository
{
    /**
     * @param string[] $criteria format: array('name' => <name>)
     *
     * @return \KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType
     */
    public function findByUniqueCriteria(array $criteria)
    {
        return $this->_em
            ->getRepository(AbstractConfigurationType::class)
            ->findBy($criteria);
    }
}
