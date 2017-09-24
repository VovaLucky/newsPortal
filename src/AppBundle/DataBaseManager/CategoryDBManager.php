<?php

namespace AppBundle\DataBaseManager;

use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\Category;

class CategoryDBManager
{
    private $db;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->db = $doctrine->getManager();
    }

    public function addCategory(Category $category)
    {
        $this->db->persist($category);
        $this->db->flush();
    }

    public function getCategoryByName(string $name):? Category
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Category')
            ->findOneBy(['name' => $name]);
    }

    public function isCategoryExist(string $name): bool
    {
        return null !== $this->getCategoryByName($name);
    }

    public function getSubCategories(?int $category): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Category')
            ->findBy(['parent' => $category], ['name' => 'ASC']);
    }

    public function getAllCategories(): array
    {
        return $this->db
            ->getRepository('AppBundle\Entity\Category')
            ->findBy([], ['name' => 'ASC']);
    }
}