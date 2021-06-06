<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\ProductRepository")
 */


class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $publisher_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pprice;

    /**
     * @ORM\Column(type="float")
     */
    private $sprice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detail;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $writer_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPublisherId(): ?int
    {
        return $this->publisher_id;
    }

    public function setPublisherId(?int $publisher_id): self
    {
        $this->publisher_id = $publisher_id;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getPprice(): ?float
    {
        return $this->pprice;
    }

    public function setPprice(?float $pprice): self
    {
        $this->pprice = $pprice;

        return $this;
    }

    public function getSprice(): ?float
    {
        return $this->sprice;
    }

    public function setSprice(float $sprice): self
    {
        $this->sprice = $sprice;

        return $this;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(?int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(?string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getWriterId(): ?int
    {
        return $this->writer_id;
    }

    public function setWriterId(?int $writer_id): self
    {
        $this->writer_id = $writer_id;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
