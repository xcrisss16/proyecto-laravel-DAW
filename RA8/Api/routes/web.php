<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

URL::forceRootUrl('https://cautious-space-enigma-7vqxp7qppj6vhxpvx-8000.app.github.dev');
URL::forceScheme('https');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    $user = \App\Models\User::where('email', $email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($password, $user->password)) {
        return view('auth.login', [
            'error' => 'Invalid credentials. Please try again.',
            'email' => $email
        ]);
    }

    Auth::login($user);
    $request->session()->regenerate();
    $request->session()->put('user_id', $user->id);
    $request->session()->put('user_name', $user->name);
    $request->session()->save();

    return response('<script>window.location.href="/products";</script>');

})->name('login.post');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response('<script>window.location.href="/login";</script>');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);
});