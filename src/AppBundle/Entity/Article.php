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
     * @ORM\Column(name="text", type="text")
     */
    private $text;
    const SIZE_SHORT_TEXT = 150;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="view", type="integer")
     */
    private $view;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id");
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="article")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="similarArticles")
     */
    private $articlesWithThis;

    /**
     * @ORM\ManyToMany(targetEntity="Article", inversedBy="articlesWithThis")
     * @ORM\JoinTable(name="similar_articles",
     *      joinColumns={@ORM\JoinColumn(name="base_article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="similar_article_id", referencedColumnName="id")}
     *      )
     */
    private $similarArticles;

    public function __construct()
    {
        $this->articlesWithThis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->similarArticles = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setView(int $view)
    {
        $this->view = $view;
    }

    public function getView(): int
    {
        return $this->view;
    }

    public function increaseView()
    {
        $this->view++;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setArticlesWithThis(array $articlesWithThis)
    {
        $this->articlesWithThis = new \Doctrine\Common\Collections\ArrayCollection($articlesWithThis);
    }

    public function getArticlesWithThis(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->articlesWithThis;
    }

    public function setSimilarArticles(array $similarArticles)
    {
        $this->similarArticles = new \Doctrine\Common\Collections\ArrayCollection($similarArticles);
    }

    public function getSimilarArticles(): \Doctrine\Common\Collections\ArrayCollection
    {
        return $this->similarArticles;
    }
}

