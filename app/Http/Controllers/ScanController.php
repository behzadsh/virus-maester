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

        return $this->handleResponse($response, 'file');
    }

    public function fileReport($scanId)
    {
        $fileApi = new File(env('VT_API_KEY'));
        $report = $fileApi->getReport($scanId);

        if ($report['response_code'] != 1) {
            $data = [
                'message'   => "<b>File is still in the queue.</b> Wait a minute and click the button below to view the results.",
                'scan_id'   => $report['scan_id'],
                'type'      => 'file'
            ];

            return view('queued_scan', $data);
        }

        $data = [
            'defected' => $report['positives'] > 0,
            'ratio'    => "{$report['positives']} / {$report['total']}",
            'date'     => $report['scan_date'],
            'scans'    => $report['scans'],
            'type'     => 'file'
        ];

        return view('results', $data);
    }

    public function url(Requests\UrlScanRequest $request)
    {
        $url = $request->get('url');

        $response = VirusTotalApi::scanFileViaUrl($url);

        return $this->handleResponse($response, 'url');
    }

    public function urlReport($scanId)
    {
        $urlApi = new Url(env('VT_API_KEY'));
        $report = $urlApi->getReport($scanId);

        if ($report['response_code'] != 1) {
            $data = [
                'message'   => "Url is still in the queue. Wait a minute and click the button below to view the results.",
                'scan_id'   => $report['scan_id'],
                'type'      => 'url'
            ];

            return view('queued_scan', $data);
        }

        $data = [
            'defected' => $report['positives'] > 0,
            'ratio'    => "{$report['positives']} / {$report['total']}",
            'date'     => $report['scan_date'],
            'scans'    => $report['scans'],
            'type'     => 'url'
        ];

        return view('results', $data);
    }

    private function handleResponse($response, $type)
    {
        if ($response['success']) {
            $data = [
                'message'   => "The requested $type queued for scanning. This may take some times. Click the button below to view the results.",
                'scan_id'   => $response['scan_id'],
                'type'      => $type
            ];

            return view('queued_scan', $data);
        } elseif ($response['error'] == 'rate limit exceeded') {
            return view('errors.api_limits');
        }

        return view('errors.503');
    }

}
