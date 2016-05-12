<?php

namespace Maester\Http\Controllers;

use Maester\Http\Requests;
use moay\VirusTotalApi\VirusTotalApi;
use VirusTotal\File;
use VirusTotal\Url;

class ScanController extends Controller
{

    public function file(Requests\FileScanRequest $request)
    {
        $file = $request->file('file');
        $fileHash = hash_file('sha256', $file);
        $file = $file->move(storage_path("files"), "$fileHash.{$file->getClientOriginalExtension()}");
        $response = VirusTotalApi::scanFile($file->getPathname());

        if ($report = $this->handleResponse($response, 'file')) {
            dd($report);
        }

        return view('errors.api_limits');
    }

    public function url()
    {
    }

    private function handleResponse($response, $type)
    {
        if ($response['success']) {
            /** @var File|Url $virusTotal */
            $virusTotal = $this->getApiClass($type);

            return $virusTotal->getReport($response['scan_id']);
        } elseif ($response['error'] == 'rate limit exceeded') {
            return false;
        }
    }

    private function getApiClass($type)
    {
        if ($type == 'file') {
            return new File(env('VT_API_KEY'));
        } elseif ($type == 'url') {
            return new Url(env('VT_API_KEY'));
        }

        throw new \Exception('invalid virus total driver type');
    }

}
