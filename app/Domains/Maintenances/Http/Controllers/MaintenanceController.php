<?php

namespace App\Domains\Maintenances\Http\Controllers;

use App\Domains\Maintenances\Services\MaintenanceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{

    private $maintenanceService;

    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    public function all(Request $request, $id): JsonResponse
    {
        return $this->maintenanceService->all($request, $id);
    }

    public function save(Request $request, $id): JsonResponse
    {
        return $this->maintenanceService->saveMaintenance($request, $id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function delete(Request $request, $id): JsonResponse
    {
        return $this->maintenanceService->deleteMaintenance($request, $id);
    }
}
