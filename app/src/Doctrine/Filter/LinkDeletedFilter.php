<?php

namespace App\Doctrine\Filter;

use App\Entity\Link;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class LinkDeletedFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->getReflectionClass()->name !== Link::class) {
            return '';
        }

        $this->setParameter('datetime', new \DateTimeImmutable());

        if (trim($this->getParameter('deleted'), "'")) {
            return sprintf('%s.deleted_at < %s', $targetTableAlias, $this->getParameter('datetime'));
        }

        return sprintf('%1$s.deleted_at > %2$s OR ISNULL(%1$s.deleted_at)', $targetTableAlias, $this->getParameter('datetime'));
    }
}
