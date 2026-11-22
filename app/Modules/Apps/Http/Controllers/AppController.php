<?php

namespace App\Modules\Apps\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Apps\Http\Requests\StoreAppRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AppController extends Controller
{
    /**
     * Show the form for creating a new app.
     */
    public function create(): View
    {
        return view('apps::create');
    }

    /**
     * Store a newly created app for the authenticated user.
     */
    public function store(StoreAppRequest $request): RedirectResponse
    {
        $request->user()->apps()->create($request->validated());

        return redirect(route('dashboard'))->with('status', 'app-created');
    }
}
