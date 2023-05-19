<?php

namespace App\Http\Middleware;

use App\Models\TemporaryFile;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DeleteImagesOnEditAndCreteForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $temporaryImages = TemporaryFile::all();
        foreach($temporaryImages as $temporaryImage){
            Storage::deleteDirectory('public/products/tmp/'.$temporaryImage->folder);
            $temporaryImage->delete();
        }
        return $next($request);
    }
}
