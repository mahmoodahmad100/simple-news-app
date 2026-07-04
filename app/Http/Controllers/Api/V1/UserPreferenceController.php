<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Http\Resources\UserPreferenceResource;
use App\Services\UserPreferenceService;

class UserPreferenceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly UserPreferenceService $userPreferenceService,
    ) {
    }

    /**
     * Update the specified user preference.
     */
    public function update(UpdateUserPreferenceRequest $request): UserPreferenceResource
    {
        $preferences = $this->userPreferenceService->update($request->user(), $request->validated());
        return new UserPreferenceResource($preferences);
    }

    /**
     * Get the specified user preferences.
     */
    public function index(): UserPreferenceResource
    {
        return new UserPreferenceResource($this->userPreferenceService->get(request()->user()));
    }
}