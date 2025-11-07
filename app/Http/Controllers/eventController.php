<?php

namespace App\Http\Controllers;

use App\Http\Requests\eventStoreRequest;
use App\Http\Requests\eventUpdateRequest;
use App\Models\Event;
use App\Models\event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class eventController extends Controller
{
    public function index(Request $request): Response
    {
        $events = Event::all();

        return view('event.index', [
            'events' => $events,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('event.create');
    }

    public function store(eventStoreRequest $request): Response
    {
        $event = Event::create($request->validated());

        $request->session()->flash('event.id', $event->id);

        return redirect()->route('events.index');
    }

    public function show(Request $request, event $event): Response
    {
        return view('event.show', [
            'event' => $event,
        ]);
    }

    public function edit(Request $request, event $event): Response
    {
        return view('event.edit', [
            'event' => $event,
        ]);
    }

    public function update(eventUpdateRequest $request, event $event): Response
    {
        $event->update($request->validated());

        $request->session()->flash('event.id', $event->id);

        return redirect()->route('events.index');
    }

    public function destroy(Request $request, event $event): Response
    {
        $event->delete();

        return redirect()->route('events.index');
    }
}
