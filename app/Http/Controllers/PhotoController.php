<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PhotoController extends Controller
{
    const DEST_DIR = __DIR__.'/../../../public/images/lieux/';
    const FILE_EXT = [
        'jpg', 'jpeg', 'png', 'webp'
    ];

    public function add(Request $request, $slug, $auth)
    {
        $place = Place::find($slug);

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default hash admin');
        }

        if ($request->hasFile('photo') === false) {
            abort(415, 'No file provided');
        }

        if ($request->file('photo')->isValid() !== true) {
            abort(415, 'Upload failed: '.$request->file('photo')->getErrorMessage());
        }

        $file = $request->file('photo');

        if (in_array($file->guessExtension(), self::FILE_EXT) === false) {
            abort(415, 'Wrong filetype');
        }

        if ($file->getSize() > $file->getMaxFilesize()) {
            abort(415, 'File too large. Max file size is : '.$file->getMaxFilesize());
        }

        $filename = Str::slug($file->getClientOriginalName()).'-'.Str::random(6).'.'.$file->guessExtension();

        try {
            $file->move(self::DEST_DIR, $filename);
            $place->addPhoto($filename);
            $place->save();
        } catch (FileException $e) {
            $err = $e->getMessage();
        }

        return redirect(route('place.edit', compact('place', 'slug', 'auth')).'#'.$request->input('id_section', null));
    }

    public function delete(Request $request, $slug, $auth, $index)
    {
        $place = Place::find($slug);
        $photos = $place->getPhotos();

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default hash admin');
        }

        if (array_key_exists($index, $photos) === false) {
            abort(404, "Photo inexistante");
        }

        $filename = self::DEST_DIR.$photos[$index];

        if (File::exists($filename) === false || File::isFile($filename) === false) {
            abort(404, "Photo non présente sur le disque");
        }

        File::delete($filename);
        $place->deletePhoto($index);
        $place->save();

        return redirect(route('place.edit', compact('place', 'slug', 'auth')).'#'.$request->input('id_section', null));
    }
}
