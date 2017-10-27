<?php

namespace KunicMarko\SimpleConfigurationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;

class ConfigurationRepository extends EntityRepository
{
    public function findByUniqueCriteria(array $criteria)
    {
        return $this->_em
            ->getRepository(AbstractConfigurationType::class)
            ->findBy($criteria);
    }
}
