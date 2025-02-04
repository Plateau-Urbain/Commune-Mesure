<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class JsonFileController extends Controller
{
    private $basePathGeneralInformation = 'import/general_information';
    private $basePathSocialImpact = 'import/social_impact';
    private $basePathEnvironmental = 'import/environmental';

    public function index(Request $request, string $type)
    {
        $basePath = $this->getBasePathFromType($type);
        // Debug storage path
        $storagePath = storage_path($basePath);
        $exists = file_exists($storagePath);
        $isReadable = is_readable($storagePath);

        // Get all files using direct filesystem access as a fallback
        $directFiles = $exists && $isReadable ? scandir($storagePath) : [];
        $directFiles = array_filter($directFiles, function($file) {
            return !in_array($file, ['.', '..']);
        });

        // Try both Storage facade and direct filesystem
        $files = Storage::files($basePath);

        if (empty($files) && !empty($directFiles)) {
            // Use direct filesystem results if Storage facade fails
            $files = array_map(function($file) use ($basePath) {
                return $basePath . '/' . $file;
            }, $directFiles);
        }

        $jsonFiles = collect($files)->filter(function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'json';
        })->map(function ($file) use ($storagePath) {
            $fullPath = $storagePath . '/' . basename($file);
            $filename = basename($file);
            return [
                'name' => pathinfo($filename, PATHINFO_FILENAME), // Remove .json extension
                'full_name' => $filename, // Keep full name for internal use
                'size' => file_exists($fullPath) ? filesize($fullPath) : Storage::size($file),
                'last_modified' => date('Y-m-d H:i:s', file_exists($fullPath) ?
                    filemtime($fullPath) : Storage::lastModified($file))
            ];
        });

        return view('admin.json-files.index', [
            'jsonFiles' => $jsonFiles,
            'error' => $request->get('error'),
            'type' => $type,
        ]);
    }

    public function edit(string $type, string $filename)
    {
        $basePath = $this->getBasePathFromType($type);

        $path = $basePath . '/' . $filename . '.json';
        $fullPath = storage_path($path);

        if (!Storage::exists($path) && !file_exists($fullPath)) {
            return redirect()->to('admin/json-files?error=File not found');
        }

        $content = Storage::exists($path) ?
            Storage::get($path) :
            file_get_contents($fullPath);


        $jsonContent = json_decode($content);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->to('admin/json-files?error=Invalid JSON file');
        }

        return view('admin.json-files.edit', [
            'filename' => $filename,
            'content' => json_encode($jsonContent),
            'type' => $type
        ]);
    }

    public function update(Request $request, string $type, string $filename)
    {
        $basePath = $this->getBasePathFromType($type);

        $path = $basePath . '/' . $filename . '.json';
        $fullPath = storage_path($path);

        if (!Storage::exists($path) && !file_exists($fullPath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $content = $request->input('content');

        // Validate JSON
        json_decode($content);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON format'], 422);
        }

        if (Storage::exists($path)) {
            Storage::put($path, $content);
        } else {
            file_put_contents($fullPath, $content);
        }

        return response()->json(['message' => 'File updated successfully']);
    }

    public function import(Request $request, string $type, string $filename)
    {
        $basePath = $this->getBasePathFromType($type);
        $path = $basePath . '/' . $filename . '.json';
        $fullPath = storage_path($path);

        if (!Storage::exists($path) && !file_exists($fullPath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $artisanCommand = $this->getArtisanCommandFromType($type);
        $outputBuffer = new \Symfony\Component\Console\Output\BufferedOutput();

        $exitCode = Artisan::call("import:$artisanCommand", [
            'file' => $fullPath,
            '--force' => true,
        ], $outputBuffer);

        $output = $outputBuffer->fetch();

        return response()->json([
            'exit_code' => $exitCode,
            'output' => $output,
        ]);
    }

    private function getBasePathFromType(string $type) {
        switch ($type) {
            case 'general':
                return $this->basePathGeneralInformation;
                break;
            case 'social':
                return $this->basePathSocialImpact;
                break;
            case 'environmental':
                return $this->basePathEnvironmental;
                break;
            default:
                return $this->basePathGeneralInformation;
                break;
        }
    }

    private function getArtisanCommandFromType(string $type) {
        switch ($type) {
            case 'general':
                return 'typeform_generalinformation';
                break;
            case 'social':
                return 'typeform_socialimpact';
                break;
            case 'environmental':
                return 'typeform_environmental';
                break;
            default:
                return 'typeform_generalinformation';
                break;
        }
    }
}
