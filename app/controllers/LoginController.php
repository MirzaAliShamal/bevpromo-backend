<?php

class LoginController extends \BaseController {

	public function index()
	{
		return View::make('login');
	}

    public function create()
    {
        return View::make('login');
    }

	public function store()
    {
         /*$user = User::create(array(
            'email' => 'nikultaka@gmail.com',
            'username' => 'nikultaka',
            'password' => Hash::make('Testing@123'),
            'code' => 'test',
            'active' => 1));
        die;*/    
        $input = Input::only('email', 'password');
        
        /*echo "<pre>";
        print_r($input);
        die;*/

        if (Auth::attempt($input))
        {

            return Redirect::to('/');

        }

        return Redirect::back()->withInput()->withFlashMessage('Invalid Email or Password');
    }

    public function destroy()
    {
        Auth::logout();

        return Redirect::to('login');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        return View::make('reset')->with('user', $user);
    }

    public function updatePassword($id)
    {
        $user = User::findOrFail($id);

        $user->password = Hash::make(Input::get('password'));

        $user->save();

        return Redirect::to('/admin/clients/' . $id . '/edit');
    }

}