<?php

namespace KunicMarko\SimpleConfigurationBundle\Tests\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use KunicMarko\SimpleConfigurationBundle\Repository\ConfigurationRepository;
use Mockery;

class MockConfigurationRepository
{
    public static function getAllMock($returnValue)
    {
        $entityManager = self::mockGetAllEntityManager($returnValue);

        return new ConfigurationRepository($entityManager);
    }

    public static function getValueForMock($returnValue)
    {
        $entityManager = self::mockGetValueForEntityManager($returnValue);

        return new ConfigurationRepository($entityManager);
    }

    private static function mockGetAllEntityManager($returnValue)
    {
        $entityManager = Mockery::mock(EntityManager::class);
        $queryBuilder = Mockery::mock(QueryBuilder::class);
        $query = Mockery::mock(AbstractQuery::class);

        $query->shouldReceive('getArrayResult')
            ->andReturn($returnValue);

        $queryBuilder->shouldReceive([
            'select'   => $queryBuilder,
            'from'     => $queryBuilder,
            'getQuery' => $query,
        ]);

        $entityManager->shouldReceive('createQueryBuilder')
            ->andReturn($queryBuilder);

        return $entityManager;
    }

    private static function mockGetValueForEntityManager($returnValue)
    {
        $entityManager = Mockery::mock(EntityManager::class);
        $queryBuilder = Mockery::mock(QueryBuilder::class);
        $query = Mockery::mock(AbstractQuery::class);

        $query->shouldReceive('getOneOrNullResult')
            ->andReturn($returnValue);

        $queryBuilder->shouldReceive([
            'select'       => $queryBuilder,
            'from'         => $queryBuilder,
            'where'        => $queryBuilder,
            'setParameter' => $queryBuilder,
            'getQuery'     => $query,
        ]);

        $entityManager->shouldReceive('createQueryBuilder')
            ->andReturn($queryBuilder);

        return $entityManager;
    }
}
