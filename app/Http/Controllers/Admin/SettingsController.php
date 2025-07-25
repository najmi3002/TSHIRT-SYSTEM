<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function editWhatsapp()
    {
        return view('admin.settings.whatsapp', [
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'whatsapp_message' => Setting::get('whatsapp_message', ''),
        ]);
    }

    public function updateWhatsapp(Request $request)
    {
        $request->validate([
            'whatsapp_number' => 'required|string',
            'whatsapp_message' => 'required|string',
        ]);

        Setting::set('whatsapp_number', $request->whatsapp_number);
        Setting::set('whatsapp_message', $request->whatsapp_message);

        return back()->with('success', 'Berjaya dikemaskini!');
    }
} 