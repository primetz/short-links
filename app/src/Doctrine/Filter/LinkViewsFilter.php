<?php

namespace App\Doctrine\Filter;

use App\Entity\Link;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class LinkViewsFilter extends SQLFilter
{

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias): string
    {
        if ($targetEntity->getReflectionClass()->name !== Link::class) {
            return '';
        }

        return sprintf('%s.views >= %s', $targetTableAlias, $this->getParameter('views'));
    }
}
