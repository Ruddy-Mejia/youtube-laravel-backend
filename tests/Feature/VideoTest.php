<?php

use App\Models\User;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
});
test('lista videos paginados', function () {
    Video::factory()->count(3)->create();

    $this->getJson('/api/videos')
         ->assertOk()
         ->assertJsonCount(3, 'data');
});

test('lista videos incluye author', function () {
    $video = Video::factory()->create();

    $this->getJson('/api/videos')
         ->assertOk()
         ->assertJsonPath('data.0.author.id', $video->user_id);
});
test('muestra un video especifico', function () {
    $video = Video::factory()->create();

    $this->getJson("/api/videos/{$video->id}")
         ->assertOk()
         ->assertJsonPath('data.id', $video->id);
});

test('retorna 404 si el video no existe', function () {
    $this->getJson('/api/videos/9999')
         ->assertNotFound();
});

test('incrementa views al ver un video', function () {
    $video = Video::factory()->create(['views' => 0]);

    $this->getJson("/api/videos/{$video->id}");

    expect($video->fresh()->views)->toBe(1);
});
test('usuario autenticado puede crear un video', function () {
    $user = actingAsUser();
    $category = Category::factory()->create();

    $payload = [
        'title' => 'My first video',
        'description' => 'Description here',
        'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
        'categories' => [$category->id],
    ];

    $this->postJson('/api/videos', $payload)
         ->assertCreated()
         ->assertJsonPath('data.title', 'My first video');

    $this->assertDatabaseHas('videos', [
        'user_id' => $user->id,
        'title' => 'My first video',
    ]);
});

test('guarda el thumbnail en storage', function () {
    actingAsUser();

    $this->postJson('/api/videos', [
        'title' => 'Video with thumb',
        'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
    ])->assertCreated();

    $video = Video::first();

    Storage::disk('public')->assertExists($video->thumbnail_path);
});

test('usuario no autenticado no puede crear video', function () {
    $this->postJson('/api/videos', [
        'title' => 'Test',
    ])->assertUnauthorized();
});
test('title es requerido', function () {
    actingAsUser();

    $this->postJson('/api/videos', [
        'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
    ])->assertUnprocessable()
      ->assertJsonValidationErrors('title');
});

test('thumbnail debe ser imagen', function () {
    actingAsUser();

    $this->postJson('/api/videos', [
        'title' => 'Test',
        'thumbnail' => UploadedFile::fake()->create('file.pdf', 100),
    ])->assertUnprocessable()
      ->assertJsonValidationErrors('thumbnail');
});

test('thumbnail no puede pesar mas de 2MB', function () {
    actingAsUser();

    $this->postJson('/api/videos', [
        'title' => 'Test',
        'thumbnail' => UploadedFile::fake()->image('big.jpg')->size(3000),
    ])->assertUnprocessable()
      ->assertJsonValidationErrors('thumbnail');
});
test('dueño puede actualizar su video', function () {
    $user = actingAsUser();
    $video = Video::factory()->for($user)->create();

    $this->putJson("/api/videos/{$video->id}", [
        'title' => 'Updated title',
    ])->assertOk()
      ->assertJsonPath('data.title', 'Updated title');

    expect($video->fresh()->title)->toBe('Updated title');
});

test('usuario no puede actualizar video de otro', function () {
    actingAsUser();
    $video = Video::factory()->create();

    $this->putJson("/api/videos/{$video->id}", [
        'title' => 'Hacked',
    ])->assertForbidden();
});

test('usuario no autenticado no puede actualizar', function () {
    $video = Video::factory()->create();

    $this->putJson("/api/videos/{$video->id}", [
        'title' => 'Test',
    ])->assertUnauthorized();
});
test('dueño puede eliminar su video', function () {
    $user = actingAsUser();
    $video = Video::factory()->for($user)->create();

    $this->deleteJson("/api/videos/{$video->id}")
         ->assertNoContent();

    $this->assertDatabaseMissing('videos', ['id' => $video->id]);
});

test('usuario no puede eliminar video de otro', function () {
    actingAsUser();
    $video = Video::factory()->create();

    $this->deleteJson("/api/videos/{$video->id}")
         ->assertForbidden();
});