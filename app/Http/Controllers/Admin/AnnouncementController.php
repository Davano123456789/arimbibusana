<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('dashboard.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('dashboard.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $imagePath = $request->file('image')->store('announcements', 'public');

        Announcement::create([
            'title' => $request->title,
            'image' => $imagePath,
            'link_url' => $request->link_url,
            'is_active' => $request->has('is_active'),
            'show_as_popup' => $request->has('show_as_popup'),
        ]);

        // If this one is set as popup, we might want to unset others (optional based on preference)
        // For now, let's just create it. We can have a dedicated "Set as Popup" toggle.

        return redirect()->route('dashboard.announcements.index')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('dashboard.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'link_url' => $request->link_url,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $data['image'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);

        return redirect()->route('dashboard.announcements.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        $announcement->delete();

        return redirect()->route('dashboard.announcements.index')->with('success', 'Informasi berhasil dihapus.');
    }

    public function togglePopup($id)
    {
        $target = Announcement::findOrFail($id);
        
        // If we're setting this as popup, unset others
        if (!$target->show_as_popup) {
            Announcement::where('show_as_popup', true)->update(['show_as_popup' => false]);
            $target->show_as_popup = true;
            $target->is_active = true; // Auto activate if set as popup
        } else {
            $target->show_as_popup = false;
        }
        
        $target->save();

        return redirect()->route('dashboard.announcements.index')->with('success', 'Status popup berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->is_active = !$announcement->is_active;
        
        // If deactivating, ensuring it's not a popup anymore
        if (!$announcement->is_active) {
            $announcement->show_as_popup = false;
        }
        
        $announcement->save();

        return redirect()->route('dashboard.announcements.index')->with('success', 'Status informasi berhasil diubah.');
    }
}
