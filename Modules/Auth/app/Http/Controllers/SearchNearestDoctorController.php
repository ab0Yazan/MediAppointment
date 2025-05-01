<?php
namespace Modules\Auth\app\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Auth\app\Models\Doctor;
use Modules\Auth\Http\Requests\SearchNearestDoctorRequest;
use Modules\Auth\Transformers\GetSearchDoctorResource;
use Modules\Geo\app\Actions\SearchNearestModelAction;

final class SearchNearestDoctorController
{
    public function __invoke(SearchNearestDoctorRequest $request, SearchNearestModelAction $action): JsonResponse
    {
        $data = $action->execute($request->getSearchNearestDoctorDto()->getGeoPoint(), Doctor::class, ["speciality" =>$request->getSearchNearestDoctorDto()->getSpeciality()]);
        $data = GetSearchDoctorResource::collection($data);
        return response()->json($data);
    }
}
