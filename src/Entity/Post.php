<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFormat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bgColor1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bgColor2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFormat(): ?string
    {
        return $this->imageFormat;
    }

    public function setImageFormat(?string $imageFormat): static
    {
        $this->imageFormat = $imageFormat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAuthor(): ?int
    {
        return $this->author;
    }

    public function setAuthor(int $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getBgColor1(): ?string
    {
        return $this->bgColor1;
    }

    public function setBgColor1(?string $bgColor1): static
    {
        $this->bgColor1 = $bgColor1;

        return $this;
    }

    public function getBgColor2(): ?string
    {
        return $this->bgColor2;
    }

    public function setBgColor2(?string $bgColor2): static
    {
        $this->bgColor2 = $bgColor2;

        return $this;
    }
}
