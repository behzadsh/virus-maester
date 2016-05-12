<?php

namespace Maester\Http\Controllers;

use Maester\Http\Requests;
use moay\VirusTotalApi\VirusTotalApi;
use VirusTotal\File;

class ScanController extends Controller
{

    public function file(Requests\FileScanRequest $request)
    {
        $file = $request->file('file');
        $fileHash = hash_file('sha256', $file);
        $file = $file->move(storage_path("files"), "$fileHash.{$file->getClientOriginalExtension()}");
        $response = VirusTotalApi::scanFile($file->getPathname());

        return $this->handleResponse($response, 'file');
    }

    public function fileReport($scanId)
    {
        $fileApi = new File(env('VT_API_KEY'));
        $report = $fileApi->getReport($scanId);

        $data = [
            'defected' => $report['positives'] > 0,
            'ratio'    => "{$report['positives']} / {$report['total']}",
            'date'     => $report['scan_date'],
            'scans'    => $report['scans']
        ];

        return view('results', $data);
    }

    public function url()
    {
    }

    public function urlReport()
    {

    }

    private function handleResponse($response, $type)
    {
        if ($response['success']) {
            $data = [
                'message'   => $response['verbose_msg'],
                'scan_id'   => $response['scan_id'],
                'permalink' => $response['permalink'],
                'type'      => $type
            ];

            return view('queued_scan', $data);
        } elseif ($response['error'] == 'rate limit exceeded') {
            return view('errors.api_limits');
        }

        return view('errors.503');
    }

}
