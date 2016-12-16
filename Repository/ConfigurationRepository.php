<?php

namespace KunicMarko\ConfigurationPanelBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConfigurationRepository extends EntityRepository
{
    /**
     * @param $mediaTypeId
     * @return mixed
     */
    public function getMediaTypeById($mediaTypeId)
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT m.* FROM configuration c inner join media__media m on c.media = m.id where c.id = :mediaTypeId";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'mediaTypeId' => $mediaTypeId
        ]);
        return $stmt->fetch();
    }
}