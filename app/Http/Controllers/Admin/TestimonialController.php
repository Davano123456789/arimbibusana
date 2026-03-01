<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('product')->latest()->paginate(10);
        return view('dashboard.testimonials.index', compact('testimonials'));
    }

    public function show($id)
    {
        $testimonial = Testimonial::with('product')->findOrFail($id);
        return view('dashboard.testimonials.show', compact('testimonial'));
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('dashboard.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }

    public function toggleDisplay($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_displayed = !$testimonial->is_displayed;
        $testimonial->save();

        return redirect()->route('dashboard.testimonials.index')->with('success', 'Status tampilan testimonial berhasil diubah.');
    }
}
