<?php 

    namespace App\Entity;

    use DateTime;
    use DateTimeImmutable;
    use Doctrine\ORM\Mapping as ORM;
    use App\Repository\CategoryRepository;
    use Symfony\Component\Validator\Constraints as Assert;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
   

    #[ORM\Entity(repositoryClass: CategoryRepository::class)]
    #[UniqueEntity('id')]
    class Category
    {
        /** Variables privadas de la clase */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id;

        #[ORM\Column(type: 'string', length: 250)]
        #[Assert\NotBlank()]
        private string $name;

        #[ORM\Column(type: 'boolean')]
        public bool $active;

        #[ORM\Column(type: 'datetime_immutable')]
        #[Assert\NotNull()]
        private ?DateTimeImmutable $createdAt;

        #[ORM\Column(type: 'datetime_immutable')]
        #[Assert\NotNull()]
        private ?DateTimeImmutable $updatedAt;
        /** Constructor de la clase */
        public function __construct()
        {
            $this->createdAt = new \DateTimeImmutable();
            $this->updatedAt = new \DateTimeImmutable();
            $this->active = 1;
        }
        /** Funciones Get */
        public function getId(): ?int
        {
            return $this->id;
        }

        public function getName(): ?string
        {
            return $this->name;
        }

        public function getActive(): ?bool
        {
            return $this->active;
        }

        public function getCreatedAt(): ?DateTimeImmutable
        {
            return $this->createdAt;
        }

        public function getUpdatedAt(): ?DateTimeImmutable
        {
            return $this->updatedAt;
        }
        /** Funciones Set */
        public function setId($value): self
        {
            $this->id = $value;
            return $this;
        }

        public function setName($value): self
        {
            $this->name = $value;
            return $this;
        }

        public function setActive($value): self
        {
            $this->active = $value;
            return $this;
        }

        public function setCreatedAt($value): self
        {
            $this->createdAt = $value;
            return $this;
        }

        public function setUpdatedAt($value): self
        {
            $this->updatedAt = $value;
            return $this;
        }
    }

?>