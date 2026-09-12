<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonitoringSetting;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

class MonitoringSettingController extends Controller
{
    public function show()
    {
        return response()->json(MonitoringSetting::getSettings());
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'raw_metrics_retention_days' => 'required|integer|min:1|max:3650',
        ]);

        $settings = MonitoringSetting::getSettings();
        $before = $settings->toArray();

        $settings->update($validated);

        AuditLogger::log('settings.updated', 'MonitoringSetting', (string) $settings->id, $before, $settings->toArray());

        return response()->json($settings);
    }
}
