<?php

namespace App\Repositories;
use App\Models\HistoryStatus;
use App\Models\WebService;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\ProcessWebServices;

class WebServiceProvider implements WebServiceProviderInterface
{
    /**
     * Success status ID in DB
     */
    public const SUCCESS_STATUS = 1;

    /**
     * Error status ID in DB
     */
    public const ERROR_STATUS = 2;

    /**
     * Display a listing of the resource.
     * @return Collection
     */
    public function all(): \Illuminate\Support\Collection
    {
        return WebService::with('history.status')->get()->map(function ($item) {
            $status = [];
            $i = 1;
            foreach ($item->history as $value) {
                if ($i == 5) {
                    break;
                }
                $status[] = $value->status->id;
                $i++;
            }

            $mostStatus = $this->calcPercentageOfStatus($status, self::SUCCESS_STATUS);
            $showStatus = ($mostStatus) ? HistoryStatus::find(self::SUCCESS_STATUS) : HistoryStatus::find(self::ERROR_STATUS);
            $item->status = $showStatus->name;
            return $item;
        });
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        $result = WebService::create([
            'name' => $data['name'],
            'path' => $data['path'],
        ]);

        return $result->id;
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return object|null
     */
    public function show(int $id): ?object
    {
        return WebService::find($id);
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $resource = WebService::find($id);
        if (!$resource) {
            abort(Response::HTTP_NOT_FOUND, self::NOT_RESULTS_MSG);
        }

        $resource->fill($data);
        return $resource->save();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $result = WebService::destroy($id);
        if (!$result) {
            abort(Response::HTTP_NOT_FOUND, self::NOT_RESULTS_MSG);
        }
        return (bool) $result;
    }

    /**
     * Dispatch background process to check webservices
     * @return void
     */
    public function execute(): void
    {
        ProcessWebServices::dispatch();
    }

    /**
     * Calc the most value in array
     * @param array $array
     * @param int $status
     * @return int
     */
    private function calcPercentageOfStatus(array $array, int $status): int
    {
        $totalOccurrences = 0;
        $totalCount = count($array);

        foreach ($array as $element) {
            if ($element === $status) {
                $totalOccurrences++;
            }
        }

        if ($totalCount > 0) {
            $percentage = ($totalOccurrences / $totalCount) * 100;
        } else {
            $percentage = 0;
        }

        return (int) $percentage;
    }
}
