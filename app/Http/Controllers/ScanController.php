<?php

namespace Maester\Http\Controllers;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository;
use Maester\Http\Requests;
use moay\VirusTotalApi\VirusTotalApi;
use VirusTotal\File;
use VirusTotal\Url;

class ScanController extends Controller
{

    /**
     * @var CacheManager|Repository
     */
    private $cache;

    /**
     * ScanController constructor.
     *
     * @param CacheManager $cache
     */
    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    public function file(Requests\FileScanRequest $request)
    {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $fileHash = hash_file('sha256', $file);
        $extension = $file->getClientOriginalExtension();

        $this->cache->put($fileHash, ['filename' => $filename, 'extension' => $extension], 0);

        $file = $file->move(storage_path("files"), "$fileHash.$extension");
        $response = VirusTotalApi::scanFile($file->getPathname());

        return $this->handleResponse($response, 'file');
    }

    public function fileReport($scanId)
    {
        $fileApi = new File(env('VT_API_KEY'));
        $report = $fileApi->getReport($scanId);

        if ($report['response_code'] == 0) {
            $data = [
                'title'     => 'VirusMaester - File Lost',
                'message'   => "File is Lost. The requested file is neither analyzed nor in the queue.",
                'scan_id'   => $report['scan_id'],
                'type'      => 'file'
            ];

            return view('queued_scan', $data);
        } elseif ($report['response_code'] != 1) {
            $data = [
                'title'     => 'VirusMaester - Still Analyzing File',
                'message'   => "File is still in the queue. Wait a minute and click the button below to view the results.",
                'scan_id'   => $report['scan_id'],
                'type'      => 'file'
            ];

            return view('queued_scan', $data);
        }

        $data = [
            'title'    => 'VirusMaester - File Scan Results',
            'defected' => $report['positives'] > 0,
            'sha256'   => $report['sha256'],
            'filename' => $this->getFilename($scanId),
            'ratio'    => "{$report['positives']} / {$report['total']}",
            'date'     => $report['scan_date'],
            'scans'    => $report['scans'],
        ];

        return view('file_result', $data);
    }

    public function url(Requests\UrlScanRequest $request)
    {
        $url = $request->get('url');

        $response = VirusTotalApi::scanFileViaUrl($url);

        if (isset($response['scans'])) {

            $data = [
                'title'    => 'VirusMaester - URL Scan Results',
                'defected' => $response['positives'] > 0,
                'ratio'    => "{$response['positives']} / {$response['total']}",
                'date'     => $response['scan_date'],
                'scans'    => $response['scans'],
            ];

            return view('url_results', $data);
        }

        return $this->handleResponse($response, 'url');
    }

    public function urlReport($scanId)
    {
        $urlApi = new Url(env('VT_API_KEY'));
        $report = $urlApi->getReport($scanId);

        if ($report['response_code'] == 0) {
            $data = [
                'title'     => 'VirusMaester - URL Lost',
                'message'   => "Url is Lost. The requested file is neither analyzed nor in the queue.",
                'scan_id'   => $report['scan_id'],
                'type'      => 'url'
            ];

            return view('queued_scan', $data);
        } elseif ($report['response_code'] != 1) {
            $data = [
                'title'     => 'VirusMaester - Still Analyzing URL',
                'message'   => "Url is still in the queue. Wait a minute and click the button below to view the results.",
                'scan_id'   => $report['scan_id'],
                'type'      => 'url'
            ];

            return view('queued_scan', $data);
        }

        $data = [
            'title'    => 'VirusMaester - URL Scan Results',
            'url'      => $report['url'],
            'defected' => $report['positives'] > 0,
            'ratio'    => "{$report['positives']} / {$report['total']}",
            'date'     => $report['scan_date'],
            'scans'    => $report['scans'],
        ];

        return view('url_results', $data);
    }

    private function handleResponse($response, $type)
    {
        if ($response['success']) {
            $data = [
                'title'    => 'VirusMaester - Request Queued',
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

    private function getFilename($scanId)
    {
        $fileHash = explode('-', $scanId, 2)[0];
        $fileInfo = $this->cache->get($fileHash);
        $filename = storage_path("files") . "/$fileHash.{$fileInfo['extension']}";

        if(file_exists($filename)) {
            unlink($filename);
        }
        
        return $fileInfo['filename'];
    }

}
