<?php

namespace KunicMarko\SimpleConfigurationBundle\Repository;

use Doctrine\ORM\EntityManager;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;

final class ConfigurationRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findAll() : array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(AbstractConfigurationType::class, 'c', 'c.name');

        return $queryBuilder->getQuery()
            ->getArrayResult();
    }

    public function findOneByName(string $name)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(AbstractConfigurationType::class, 'c')
            ->where('c.name = :name')
            ->setParameter(':name', $name);

        return $queryBuilder->getQuery()
            ->getOneOrNullResult();
    }
}
