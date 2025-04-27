<?php

namespace Modules\Auth\DataTransferObjects;

class ClientDto
{
    protected string $name;

    protected string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['name'], $data['email']);
    }
}
