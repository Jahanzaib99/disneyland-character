<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::paginate(10);
        return view('characters.index', compact('characters'));
    }

    public function create()
    {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:characters,name',
            'character_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->character_image->extension();

        $request->character_image->storeAs('public/character_images', $imageName);
        // Store other character details in the database

        Character::create([
            'name' => $request->name,
            'image' => 'character_images/' . $imageName,
            // Add other attributes here
        ]);

        return redirect()->route('characters.index')->with('success', 'Character created successfully.');
    }

    public function edit(Character $character)
    {
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:characters,name,' . $id,
            'character_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $character = Character::findOrFail($id);

        if ($request->hasFile('character_image')) {
            // If a new image is provided, upload and update the image
            $imageName = time() . '.' . $request->character_image->extension();
            $request->character_image->storeAs('public/character_images', $imageName);
            // Delete the old image if it exists
            Storage::delete('public/' . $character->image);
            $character->image = 'character_images/' . $imageName;
        }

        // Update other character details in the database
        $character->name = $request->name;
        // Add other attributes here

        $character->save();

        return redirect()->route('characters.index')->with('success', 'Character updated successfully.');
    }

    public function destroy(Character $character)
    {
        // Delete the associated image from storage
        Storage::delete('public/' . $character->image);
        $character->delete();

        return redirect()->route('characters.index')->with('success', 'Character deleted successfully.');
    }
}

