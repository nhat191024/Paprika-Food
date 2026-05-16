<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LocaleController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $availableLocales = collect(File::directories(lang_path()))
            ->map(fn (string $directory): string => basename($directory))
            ->reject(fn (string $locale): bool => $locale === 'vendor')
            ->values()
            ->all();

        $validated = $request->validate([
            'locale' => ['required', 'string', 'in:'.implode(',', $availableLocales)],
        ]);

        $request->session()->put('locale', $validated['locale']);

        return redirect()->back();
    }
}
