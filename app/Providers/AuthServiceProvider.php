<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Circular;
use App\Policies\CircularPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Circular::class => CircularPolicy::class,
        // เพิ่ม Model และ Policy อื่น ๆ ได้ที่นี่
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // ตัวอย่างการใช้ Gate แบบกำหนด role
        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });
    }
}
