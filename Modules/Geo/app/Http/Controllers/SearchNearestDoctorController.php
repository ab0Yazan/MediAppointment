<?php
namespace Modules\Geo\app\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Auth\app\Models\Doctor;
use Modules\Geo\app\Actions\SearchNearestModelAction;
use Modules\Geo\app\Http\Requests\SearchNearestDoctorRequest;
use Modules\Geo\app\Transformers\GetSearchDoctorResource;

final class SearchNearestDoctorController
{
    public function __invoke(SearchNearestDoctorRequest $request, SearchNearestModelAction $action): JsonResponse
    {
        $data = $action->execute($request->getSearchNearestDoctorDto()->getGeoPoint(), Doctor::class, ["speciality" =>$request->getSearchNearestDoctorDto()->getSpeciality()]);
        $data = GetSearchDoctorResource::collection($data);
        return response()->json($data);
    }
}
