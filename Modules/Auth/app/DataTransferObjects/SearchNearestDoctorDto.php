<?php
namespace Modules\Auth\app\DataTransferObjects;
use Modules\Geo\app\ValueObjects\GeoPoint;

class SearchNearestDoctorDto
{
    protected GeoPoint $point;
    protected ?string $speciality;

    public function __construct(GeoPoint $point, ?string $speciality = null)
    {
        $this->point = $point;
        $this->speciality = $speciality;
    }

    public function getGeoPoint(): GeoPoint
    {
        return $this->point;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public static function fromArray(array $data): SearchNearestDoctorDto
    {
        $data['point'] = new GeoPoint($data['latitude'], $data['longitude']);
        return new self($data['point'], $data['speciality'] ?? null);
    }


}
