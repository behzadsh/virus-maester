<?php

namespace Maester\Http\Controllers;

use Maester\Http\Requests;
use moay\VirusTotalApi\VirusTotalApi;

class ScanController extends Controller
{

    public function file(Requests\FileScanRequest $request)
    {
        $file = $request->file('file');
        $fileHash = hash_file('sha256', $file);
        $file = $file->move(storage_path("files"), "$fileHash.{$file->getClientOriginalExtension()}");
        $response = VirusTotalApi::scanFile($file->getPathname());
        dd($response);
    }

    public function url()
    {
    }

}
