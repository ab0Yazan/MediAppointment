<?php

namespace Modules\Auth\app\DataTransferObjects;

use Modules\Geo\app\ValueObjects\GeoPoint;

class DoctorDto
{

    protected string $name;

    protected string $email;
    protected string $speciality;
    protected ?GeoPoint $geoPoint;
    public function __construct(string $name, string $email, string $speciality, string $latitude=null, string $longitude=null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->speciality = $speciality;
        $this->geoPoint=null;
        if($latitude && $longitude){
            $this->geoPoint = new GeoPoint($latitude, $longitude);
        }
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
        return new self($data['name'], $data['email'], $data['speciality'], $data['latitude']??null, $data['longitude']??null);
    }

    public function getGeoPoint(): ?GeoPoint
    {
        return $this->geoPoint;
    }

}
