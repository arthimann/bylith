<?php

namespace App\Repositories;

interface WebServiceProviderInterface
{
    /**
     * Not found result message
     */
    public const NOT_RESULTS_MSG = 'Nothing found';

    /**
     * Store success message
     */
    public const STORE_SUCCESS_MSG = 'New URL added successfully';

    /**
     * Display a listing of the resources.
     * @return \Illuminate\Support\Collection
     */
    public function all(): \Illuminate\Support\Collection;

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return int
     */
    public function store(array $data): int;

    /**
     * Display the specified resource.
     * @param int $id
     * @return object|null
     */
    public function show(int $id): ?object;

    /**
     * Update the specified resource in storage.
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * Dispatch background process to check webservices
     * @return void
     */
    public function execute(): void;
}
