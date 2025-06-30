<?php

namespace App\Observers;

use Spatie\Activitylog\Contracts\Activity;
use App\Models\IpAddress;
use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Tymon\JWTAuth\Facades\JWTAuth;

class IpAddressObserver
{
    /**
     * Handle the IpAddress "created" event.
     */
    public function created(IpAddress $ipAddress): void
    {
        $user = User::find(JWTAuth::user()->id);

        activity()
            ->causedBy($user)
            ->performedOn($ipAddress)
            ->withProperties(['new' => $ipAddress->getDirty(), 'old' => $ipAddress->getOriginal()])
            ->tap(function(Activity $activity) {
                $activity->session_id = request()->header('X-Session-Id');
            })
            ->log('created');
    }

    /**
     * Handle the IpAddress "updated" event.
     */
    public function updated(IpAddress $ipAddress): void
    {
        $user = User::find(JWTAuth::user()->id);

        activity()
            ->causedBy($user)
            ->performedOn($ipAddress)
            ->withProperties(['new' => $ipAddress->getChanges(), 'old' => $ipAddress->getPrevious()])
            ->tap(function(Activity $activity) {
                $activity->session_id = request()->header('X-Session-Id');
            })
            ->log('edited');
    }

    /**
     * Handle the IpAddress "deleted" event.
     */
    public function deleted(IpAddress $ipAddress): void
    {
        $user = User::find(JWTAuth::user()->id);

        activity()
            ->causedBy($user)
            ->performedOn($ipAddress)
            ->withProperties(['old' => $ipAddress])
            ->tap(function(Activity $activity) {
                $activity->session_id = request()->header('X-Session-Id');
            })
            ->log('deleted');
    }

    /**
     * Handle the IpAddress "restored" event.
     */
    public function restored(IpAddress $ipAddress): void
    {
        //
    }

    /**
     * Handle the IpAddress "force deleted" event.
     */
    public function forceDeleted(IpAddress $ipAddress): void
    {
        //
    }
}
