<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;

class JokeRepository extends EntityRepository
{
    public function findOneRandom()
    {
        $query = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery();

        $count = $query->getSingleScalarResult();

        if ($count == 0){
            throw new Exception('No jokes found');
        }

        $query = $this->createQueryBuilder('p')
            ->setFirstResult(mt_rand(0, $count - 1))
            ->setMaxResults(1)
            ->getQuery();

        return $query->setMaxResults(1)->getOneOrNullResult();
    }
}