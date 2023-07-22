<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Repositories\WebServiceProvider;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\V1\Services\StoreRequest;
use App\Http\Requests\V1\Services\UpdateRequest;
use Symfony\Component\HttpFoundation\Response;

class WebServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param WebServiceProvider $webServiceProvider
     * @return JsonResponse
     */
    public function index(WebServiceProvider $webServiceProvider): JsonResponse
    {
        $data = $webServiceProvider->all();
        return response()->json(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @param WebServiceProvider $webServiceProvider
     * @return JsonResponse
     */
    public function store(StoreRequest $request, WebServiceProvider $webServiceProvider): JsonResponse
    {
        $id = $webServiceProvider->store($request->only('name', 'path'));
        return response()->json([
            'message' => $webServiceProvider::STORE_SUCCESS_MSG,
            'id' => $id,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @param WebServiceProvider $webServiceProvider
     * @return JsonResponse
     */
    public function show(string $id, WebServiceProvider $webServiceProvider): JsonResponse
    {
        $data = $webServiceProvider->show($id);
        if (!$data) {
            abort(Response::HTTP_NOT_FOUND, $webServiceProvider::NOT_RESULTS_MSG);
        }
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param string $id
     * @param WebServiceProvider $webServiceProvider
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, string $id, WebServiceProvider $webServiceProvider): JsonResponse
    {
        $result = $webServiceProvider->update($id, $request->only('name', 'path'));
        return response()->json(compact('id', 'result'));
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @param WebServiceProvider $webServiceProvider
     * @return JsonResponse
     */
    public function destroy(string $id, WebServiceProvider $webServiceProvider): JsonResponse
    {
        $result = $webServiceProvider->destroy($id);
        return response()->json(compact('id', 'result'));
    }
}
