<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

function currentItems() {
    return Cache::get('currentItems', function () {
        return [];
    });
}

function addItem($item) {
    Cache::put('currentItems', array_merge([$item], currentItems()));
}

Route::get('/', function () {
    $availableItems = collect([
        ['id' => 1, 'name' => 'Computer'],
        ['id' => 2, 'name' => 'Laptop'],
        ['id' => 3, 'name' => 'Windows 11'],
        ['id' => 4, 'name' => 'Phone'],
        ['id' => 5, 'name' => 'Axe'],
    ])->reject(function ($item) {
        return in_array($item['name'], currentItems());
    })->values()->toArray();

    return Inertia::render('Startpage', [
        'someString' => Str::random(10),
        'availableItems' => $availableItems,
    ]);
});

Route::post('/', function (Request $request) {
    $request->validate([
        'item' => ['required', 'string'],
    ]);

    addItem($request->item);

    return back();
});

Route::post('/restore-items', function (Request $request) {
    Cache::forget('currentItems');

    return back();
});
