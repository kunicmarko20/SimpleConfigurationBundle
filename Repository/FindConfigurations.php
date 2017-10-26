<?php

namespace KunicMarko\SonataConfigurationPanelBundle\Repository;

use Doctrine\ORM\EntityManager;
use KunicMarko\SonataConfigurationPanelBundle\Entity\AbstractConfiguration;

final class FindConfigurations
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(AbstractConfiguration::class, 'c', 'c.name');

        return $queryBuilder->getQuery()
            ->getArrayResult();
    }
}
