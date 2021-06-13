<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrow;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
            'borrowsCount' => Borrow::where('reader_id', '=', $user->id)->count(),
            'borrowsActiveCount' => Borrow::where('reader_id', '=', $user->id)->where('status', '=', 'ACCEPTED')->count(),
            'borrowsDeadlineCount' => Borrow::where('reader_id', '=', $user->id)->where('status', '=', 'ACCEPTED')->whereDate('deadline', '<', date('Y-m-d'))->count(),
            'borrowsAcceptedCount' => Borrow::where('request_managed_by', '=', $user->id)->where('status', '=', 'ACCEPTED')->count(),
            'borrowsRejectedCount' => Borrow::where('request_managed_by', '=', $user->id)->where('status', '=', 'REJECTED')->count(),
            'borrowsReturnedCount' => Borrow::where('return_managed_by', '=', $user->id)->where('status', '=', 'RETURNED')->count()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
