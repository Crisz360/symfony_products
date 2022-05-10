<?php 

    namespace App\Entity;

    use DateTime;
    use DateTimeImmutable;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Mime\Message;
    use App\Repository\ProductRepository;
    use Symfony\Component\Validator\Constraints as Assert;
    use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
     
  
    #[ORM\Entity(repositoryClass: ProductRepository::class)]
    #[UniqueEntity('id')]
    #[UniqueEntity(fields: 'code' , message: 'This code already exists')]
    #[UniqueEntity(fields: 'name' , message: 'The name already exists, please, choose another')]
    class Product
    {
        /** Variables privadas de la clase */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id;

        #[ORM\Column(type: 'string', length: 250)]
        #[Assert\NotBlank()]
        private string $code;

        #[ORM\Column(type: 'string', length: 250)]
        #[Assert\NotBlank()]
        private string $name;

        #[ORM\Column(type: 'text')]
        #[Assert\NotBlank()]
        private string $descripcion;

        #[ORM\Column(type: 'string', length: 250)]
        #[Assert\NotBlank()]
        private string $brand;

        #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
        #[ORM\JoinColumn(nullable: false)]
        private $category;

        #[ORM\Column(type: 'float')]
        #[Assert\NotNull()]
        #[Assert\Positive(message: "Valor no valido")]
        private float $price;

        #[ORM\Column(type: 'datetime_immutable')]
        private ?DateTimeImmutable $createdAt;

        #[ORM\Column(type: 'datetime_immutable')]
        private ?DateTimeImmutable $updatedAt;

        /** Constructor de la clase */
        
        public function __construct()
        {
            $this->createdAt = new \DateTimeImmutable();
            $this->updatedAt = new \DateTimeImmutable();
        }

        /** Funciones Get */
        public function getId(): ?int
        {
            return $this->id;
        }

        public function getCode(): ?string
        {
            return $this->code;
        }

        public function getName(): ?string
        {
            return $this->name;
        }

        public function getDescripcion(): ?string
        {
            return $this->descripcion;
        }

        public function getBrand(): ?string
        {
            return $this->brand;
        }

        public function getCategory(): ?Category
        {
            return $this->category;
        }

        public function getPrice(): ?float
        {
            return $this->price;
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
        public function setCode($value): self
        {
            $this->code = $value;
            return $this;
        }

        public function setName($value): self
        {
            $this->name = $value;
            return $this;
        }

        public function setDescripcion($value): self
        {
            $this->descripcion = $value;
            return $this;
        }

        public function setBrand($value): self
        {
            $this->brand = $value;
            return $this;
        }

        public function setCategory(Category $category): self
        {
            $this->category = $category;
            return $this;
        }

        public function setPrice($value): self
        {
            $this->price = $value;
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