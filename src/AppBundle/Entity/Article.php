<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    const SIZE_SHORT_TEXT = 150;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(name="view", type="integer")
     */
    private $view;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="article")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="article")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id");
     */
    private $author;

    public function getId(): int
    {
        return $this->id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getShortText(): string
    {
        $text = $this->getText();
        if (mb_strlen($text) > self::SIZE_SHORT_TEXT) {
            $text = mb_substr($text, 0, self::SIZE_SHORT_TEXT) . '...';
        }
        return $text;
    }

    public function setImage(string $image)
    {
        $this->image = $image;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setView(int $view)
    {
        $this->view = $view;
    }

    public function getView(): int
    {
        return $this->view;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}

