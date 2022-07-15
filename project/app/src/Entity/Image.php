<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $filename;
    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFile()
    {        
        return $this->file;
    }

    public function setFile(File $file)
    {        
        $nome = md5(uniqid()).'.'. ($file->guessExtension() ?: $file->getExtension());

        $file->move('../public/upload/produto/',$nome);
        $this->setFilename($nome);
        $this->file = $file;
    }

}
