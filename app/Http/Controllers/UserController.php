<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Community;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Create a new user
    public function storeUser(Request $request) {

        $messages = [
            'username.required' => 'Username is required!',
            'username.unique' => 'Username is taken! 🧟‍♂️',
            'email.required' => 'Email is required!',
            'email.unique' => 'Email is taken! 🧟‍♂️',
            'password.required' => 'Password is required!',
            'password_confirmation.required' => 'Password repeat is required!',
            'image.required' => 'Image is required!',
        ];
        
        $validatedData = $request->validate([
            'username' => ['required', 'min: 3', 'max: 255', 'unique:users,username'],
            'email' => ['required', 'email', 'max: 255', 'unique:users,email'],
            'password' => 'required|confirmed|min: 7|max: 50',
        ], $messages);

        // Check if the image is present
        if (request()->file('image') != null) {
            // Store the image
            $validatedData['image'] = request()->file('image')->store('images', 'public');
        }


        // Hash the password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Create the user
        $user = User::create($validatedData);
        
        // Log the user in
        auth()->login($user);

        // Redirect to the home page with a success message
        return redirect('/')->with('message', 'User created & logged in successfully! 🧙‍♂️');
    }

    // Login a user
    public function authenticate(Request $request) {
        $messages = [
            'username1.required' => 'Username is required!',
            'password1.required' => 'Password is required!',
        ];

        if (empty($request->username1) || empty($request->password1)) {
            return redirect('/')->withErrors(['username1' => 'Invalid Credentials! 🧟‍♂️'])->onlyInput('username1');
        }

        // Temp Solution
        $request->request->add(['username' => $request->username1]);
        $request->request->add(['password' => $request->password1]);

        $validatedData = $request->validate([
            'username' => ['required', 'max: 255'],
            'password' => ['required', 'min: 7'],
        ], $messages);

        // Check if the user exists
        if (!auth()->attempt($validatedData)) {
            return redirect('/')->withErrors(['username1' => 'Invalid Credentials! 🧟‍♂️'])->onlyInput('username1');
        }

        // Redirect to the home page with a success message
        $request->session()->regenerate();
        return redirect('/')->with('message', 'User logged in successfully! 🧙‍♂️');
    }

    // Register Modal open on homepage
    public function register() {
        // get string from url
        $url = request()->path();
        // split string into array
        $url = explode('/', $url);
        // get last element of array
        $url = end($url);

        if ($url == 'login') {
            $login = true;
            $signup = false;
        } else {
            $login = false;
            $signup = true;
        }

        return view('Communities.index', [
            'communities' => Community::latest()->get(),
            'posts' => Post::latest()->filter(request(['tag', 'search']))->paginate(9),
            'login' => $login,
            'signup' => $signup,
        ]);
    }

    // Logout a user
    public function logoutUser(Request $request) {
        auth()->logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User logged out successfully! 🧟');
    }
}