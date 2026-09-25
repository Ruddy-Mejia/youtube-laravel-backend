<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

function actingAsUser(?User $user = null): User
{
    $user ??= User::factory()->create();
    test()->actingAs($user, 'sanctum');
    return $user;
}

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
