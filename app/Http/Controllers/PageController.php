<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    /**
     * Shows the home page.
     */
    public function showHome()
    {
        return $this->showPage('today');
    }

    /**
     * Shows the specified landing page.
     */
    public function showPage(string $page)
    {
        if (! View::exists('pages.' . $page)) {
            throw new NotFoundHttpException('Page not found.');
        }

        return view('pages.' . $page);
    }

    /**
     * Returns the valid page names.
     */
    public static function getPages(): array
    {
        return array_map(function (SplFileInfo $file) {
            return str_replace('.blade.php', '', $file->getBasename());
        }, File::files(base_path('resources/views/pages')));
    }
}
