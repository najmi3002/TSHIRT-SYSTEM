<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Debug: Log the incoming request data
        \Log::info('Registration attempt', $request->all());
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
                'password' => Hash::make($request->password),
            ]);

            \Log::info('User created successfully', ['user_id' => $user->id]);

            event(new Registered($user));

            Auth::login($user);

            \Log::info('User logged in and redirecting to dashboard');

            $intended = $request->query('intended');
            if ($intended) {
                return redirect($intended);
            }

            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            \Log::error('Registration failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
