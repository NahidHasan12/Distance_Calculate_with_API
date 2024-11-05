// Distance Calculating Route
Route::post('/calculateDistance', [DistanceController::class, 'calculateDistance'])->name('location.distance');
