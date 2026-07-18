<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageSettingsController extends Controller
{
    private function getModelClass($page)
    {
        return match ($page) {
            'home'      => \App\Models\HomeSetting::class,
            'about'     => \App\Models\AboutSetting::class,
            'services'  => \App\Models\ServiceSetting::class,
            'portfolio' => \App\Models\PortfolioSetting::class,
            'contact'   => \App\Models\ContactSetting::class,
            default     => abort(404, 'Page settings not found.'),
        };
    }

    public function show($page)
    {
        $modelClass = $this->getModelClass($page);
        $setting = $modelClass::firstOrCreate([]);
        return response()->json($setting);
    }

    public function update(Request $request, $page)
    {
        $modelClass = $this->getModelClass($page);
        $setting = $modelClass::firstOrCreate([]);
        $setting->update($request->all());
        return response()->json($setting);
    }
}
