<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\User\NotificationsCollection;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    /**
     * Get the recent notifications and announcements for the user.
     *
     * @param Request $request
     *
     * @return NotificationsCollection
     */
    public function recent(Request $request): NotificationsCollection
    {
        $notifications = $request->user()->notifications()->where(function ($query) {
            $query->whereNull('read_at')
                ->orWhere('read_at', '>', now()->subDay(30)->toDateString());
        })->latest()->paginate();

        return NotificationsCollection::make($notifications);
    }

    /**
     * Mark the given notifications as read.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $this->validate($request, [
            'ids' => 'required|array',
        ]);

        $request->user()
            ->unreadNotifications()
            ->whereIn('id', $request->input('ids', []))
            ->update(['read_at' => now()]);

        return $this->responseOk();
    }
}