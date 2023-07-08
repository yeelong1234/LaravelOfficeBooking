<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Enum\UserRoleEnum;
use App\Policies\BookingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Room::class => RoomPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
       $this->registerPolicies();

       Gate::define('isAdmin', function($user) {
            return $user->role == UserRoleEnum::Admin;
       });

       Gate::define('isUser', function($user) {
            return $user->role == UserRoleEnum::User;
       });
    }
}
