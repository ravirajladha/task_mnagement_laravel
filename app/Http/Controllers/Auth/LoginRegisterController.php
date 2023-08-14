<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRegisterController extends Controller
{
    /**
     * Instantiate a new LoginRegisterController instance.
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except([
    //         'logout', 'dashboard'
    //     ]);
    // }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        $user = Auth::user();
        $request->session()->put('kods_auth_email', $user->email);
        $request->session()->put('kods_auth_userid', $user->id);

        $request->session()->put('kods_auth_user_name', $user->name);
        $request->session()->put('kods_auth_user_type', $user->user_type);

        // dd(session('kods_auth_user_type'));
        if(session('kods_auth_user_type') =="ceo"){
            return redirect()->route('pages.index')
            ->withSuccess('You have successfully registered & logged in!');
        }


        return redirect()->route('tasks.index')
            ->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->route('tasks.index')
    //             ->withSuccess('You have successfully logged in!');
    //     }

    //     return back()->withErrors([
    //         'email' => 'Your provided credentials do not match in our records.',
    //     ])->onlyInput('email');
    // }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


      
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if (
                in_array($user->user_type, [
                    "user","ceo","sr_manager","manager","employee",
                ])
            ) {
                $request->session()->regenerate();
                // Store user information in session
                $request->session()->put('kods_auth_email', $user->email);
                $request->session()->put('kods_auth_userid', $user->id);

                $request->session()->put('kods_auth_user_name', $user->name);
                $request->session()->put('kods_auth_user_type', $user->user_type);
           
                if(session('kods_auth_user_type') =="ceo"){
                    return redirect()->route('pages.index')
                    ->withSuccess('You have successfully registered & logged in!');
                }
                return redirect()->route('tasks.index')->withSuccess('You have successfully logged in!');
            } else {
                Auth::logout(); // Log out the user if the user type is not allowed
                return back()->withErrors([
                    'email' => 'Your provided credentials do not match in our records.',
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');
    }

    public function edit_profile_details(Request $request)
    {
        // return $request->all();
    
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);
         // Check if the validation has failed
    if ($request->fails()) {
     

        // If validation fails, redirect back with errors
        return redirect()->back()->withErrors($request->errors())->withInput();
    }
    dd($request->email);
        // Check if the email is changed
        if ($request->email !== $user->email) {
        
            // New email is different; check for duplicates
            $existingUser = User::where('email', $request->email)->first();
          
            if ($existingUser) {
                // Email is already taken by another user

                return to_route('tasks.update_profile_details')->withErrors([
                    'error' => 'Task not found',
                  ]);


                // return redirect()->route('tasks.update_profile_details')->with('error', 'Email already taken by another user.');
            }
    
            // Update session email with the new email
            session()->put('kods_auth_email', $request->email);
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        // Save the updated user details to the database
        $user->save();
    
        return redirect()->route('tasks.update_profile_details')->with('success', 'Profile details updated successfully.');
    }
    


    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }

        return redirect()->route('login')
            ->withErrors([
                'email' => 'Please login to access the dashboard.',
            ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }
}
