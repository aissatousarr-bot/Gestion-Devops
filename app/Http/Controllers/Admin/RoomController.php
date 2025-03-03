<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Requests\RoomRequest;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('number', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('building')) {
            $query->where('building', $request->building);
        }

        $rooms = $query->latest()->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.form');
    }

    public function store(RoomRequest $request)
    {
        Room::create($request->validated());
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Salle créée avec succès');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.form', compact('room'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Salle mise à jour avec succès');
    }

    public function destroy(Room $room)
    {
        if ($room->schedules()->exists()) {
            return back()->with('error', 'Impossible de supprimer une salle utilisée dans des emplois du temps');
        }

        $room->delete();
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Salle supprimée avec succès');
    }
}
