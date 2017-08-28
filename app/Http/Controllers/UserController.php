<?php

namespace App\Http\Controllers;

use App\Forms\BaseForm;
use App\Forms\Element;
use App\Forms\UserForm;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('company_id', Auth::user()->company_id)->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = new UserForm(route('users.store'));
        $form->getElement('role_id')->setDefault(2);
        $form->getElement('timezone')->setDefault('UTC');

        return view('users.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->fill($request->only($user->getFillable()));
        $user->company_id = Auth::user()->company_id;
        $user->role_id = 2;
        $user->password = bcrypt($request->get('password'));
        $user->save();

        flash(sprintf('The user, %s, was created successfully.', $user->fullName))->success();

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $form = new UserForm(route('users.update', $user), 'PUT');
        $form->setModel($user);
        $form->removeElement('password');
        $form->removeElement('password_confirmation');

        $form2 = new BaseForm(route('users.change-password', $user));
        $form2->addElement(new Element('password', 'Password', 'password'));
        $form2->addElement(new Element('password_confirmation', 'Confirm Password', 'password'));

        return view('users.edit', compact('user', 'form', 'form2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->only($user->getFillable()));
        $user->save();

        flash(sprintf('The user, %s, was updated successfully.', $user->fullName))->success();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users.index');
    }
}
