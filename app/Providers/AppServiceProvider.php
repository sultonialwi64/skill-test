<?php

namespace App\Providers;

use App\Models\Post; // Import Model Post
use App\Policies\PostPolicy; // Import Policy yang sudah kamu buat
use Illuminate\Support\Facades\Gate; // Import Gate
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Daftarkan Policy di sini
        Gate::policy(Post::class, PostPolicy::class);
    }
};