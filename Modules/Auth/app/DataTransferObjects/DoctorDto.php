<?php

namespace Modules\Auth\app\DataTransferObjects;
class DoctorDto
{

    protected string $name;

    protected string $email;
    protected string $speciality;
    public function __construct(string $name, string $email, string $speciality)
    {
        $this->name = $name;
        $this->email = $email;
        $this->speciality = $speciality;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSpeciality(): string
    {
        return $this->speciality;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['name'], $data['email'], $data['speciality']);
    }

}
