<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $role = (string) $request->input('role', 'student');

        $validated = $request->validate($this->rulesForRole($role));

        $user = DB::transaction(function () use ($validated, $role) {
            $user = User::create([
                'name' => $role === 'company'
                    ? $validated['company_name']
                    : $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $role,
                'matricule' => null,
            ]);

            match ($role) {
                'student' => $user->studentProfile()->create([
                    'university' => $validated['institution'],
                    'department' => $validated['department'],
                ]),
                'supervisor' => $user->supervisorProfile()->create([
                    'university' => $validated['institution'],
                    'position' => $validated['position'],
                    'department' => $validated['department'],
                ]),
                'company' => $user->companyProfile()->create([
                    'company_name' => $validated['company_name'],
                    'industry' => $validated['industry_type'],
                    'location' => $validated['company_location'],
                ]),
            };

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    protected function rulesForRole(string $role): array
    {
        $rules = [
            'role' => ['required', 'string', 'in:student,supervisor,company'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ];

        return match ($role) {
            'student' => $rules + [
                'name' => ['required', 'string', 'max:255'],
                'institution' => ['required', 'string', 'max:255'],
                'department' => ['required', 'string', 'max:255'],
            ],
            'supervisor' => $rules + [
                'name' => ['required', 'string', 'max:255'],
                'institution' => ['required', 'string', 'max:255'],
                'position' => ['required', 'string', 'max:255'],
                'department' => ['required', 'string', 'max:255'],
            ],
            'company' => $rules + [
                'company_name' => ['required', 'string', 'max:255'],
                'industry_type' => ['required', 'string', 'max:255'],
                'company_location' => ['required', 'string', 'max:255'],
            ],
            default => $rules,
        };
    }
}
