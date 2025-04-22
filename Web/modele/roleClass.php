<?php

class Role implements JsonSerializable
{
    private ?int $id;
    private string $roleName;

    public function __construct(?int $id, string $roleName)
    {
        $this->id = $id;
        $this->roleName = $roleName;
    }

    // Getter and Setter for $id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Getter and Setter for $roleName
    public function getRoleName(): string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): void
    {
        $this->roleName = $roleName;
    }

    // __toString method
    public function __toString(): string
    {
        return sprintf(
            "[Role #%d] %s",
            $this->id,
            $this->roleName
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'roleName' => $this->roleName,
        ];
    }
}

?>