<?php

namespace KunicMarko\SimpleConfigurationBundle\Repository;

use Doctrine\ORM\EntityManager;
use KunicMarko\SimpleConfigurationBundle\Entity\AbstractConfigurationType;

final class FindConfigurations
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke() : array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(AbstractConfigurationType::class, 'c', 'c.name');

        return $queryBuilder->getQuery()
            ->getArrayResult();
    }
}
