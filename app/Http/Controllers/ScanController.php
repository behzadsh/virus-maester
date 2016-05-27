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
    protected $cache;

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

        if ($report['response_code'] != 1) {
            return $this->renderStillInQueueFile($report);
        }

        return $this->renderFileResults($report);
    }

    public function url(Requests\UrlScanRequest $request)
    {
        $url = $request->get('url');

        $response = VirusTotalApi::scanFileViaUrl($url);

        if (isset($response['scans'])) {
            return $this->renderResults($response);
        }

        return $this->handleResponse($response, 'url');
    }

    public function urlReport($scanId)
    {
        $urlApi = new Url(env('VT_API_KEY'));
        $report = $urlApi->getReport($scanId);

        if ($report['response_code'] == 0) {
            return $this->fileReport($scanId);
        } elseif ($report['response_code'] != 1) {
            return $this->renderStillInQueueUrl($report);
        }

        return $this->renderUrlResults($report);
    }

    /**
     * @param $report
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function renderStillInQueueFile($report)
    {
        $data = [
            'title'   => 'VirusMaester - Still Analyzing File',
            'message' => "File is still in the queue. Wait a minute and click the button below to view the results.",
            'scan_id' => $report['resource'],
            'type'    => 'file'
        ];

        return view('queued_scan', $data);
    }

    /**
     * @param $report
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function renderStillInQueueUrl($report)
    {
        $data = [
            'title'   => 'VirusMaester - Still Analyzing URL',
            'message' => "Url is still in the queue. Wait a minute and click the button below to view the results.",
            'scan_id' => $report['resource'],
            'type'    => 'url'
        ];

        return view('queued_scan', $data);
    }

    protected function handleResponse($response, $type)
    {
        if ($response['success']) {
            $data = [
                'title'    => 'VirusMaester - Request Queued',
                'message'   => "The requested $type queued for scanning. This may take some times. Click the button below to view the results.",
                'scan_id'   => $response['resource'],
                'type'      => $type
            ];

            return view('queued_scan', $data);
        } elseif ($response['error'] == 'rate limit exceeded') {
            return view('errors.api_limits');
        }

        return view('errors.503');
    }

    protected function getFilename($scanId)
    {
        $fileHash = explode('-', $scanId, 2)[0];
        $fileInfo = $this->cache->get($fileHash);
        $filename = storage_path("files") . "/$fileHash.{$fileInfo['extension']}";

        if(file_exists($filename)) {
            unlink($filename);
        }

        return $fileInfo['filename'];
    }

    protected function renderResults($response)
    {
        if (isset($response['sha1']) || isset($response['sha256']) || isset($response['md5'])) {
            $this->renderFileResults($response);
        } else {
            $this->renderUrlResults($response);
        }
    }

    protected function renderFileResults($response)
    {
        $data = [
            'title'    => 'VirusMaester - File Scan Results',
            'defected' => $response['positives'] > 0,
            'sha256'   => $response['sha256'],
            'filename' => $this->getFilename($response['resource']),
            'ratio'    => "{$response['positives']} / {$response['total']}",
            'date'     => $response['scan_date'],
            'scans'    => $response['scans'],
        ];

        return view('file_result', $data);
    }

    protected function renderUrlResults($response)
    {
        $data = [
            'title'    => 'VirusMaester - URL Scan Results',
            'url'      => $response['url'],
            'defected' => $response['positives'] > 0,
            'ratio'    => "{$response['positives']} / {$response['total']}",
            'date'     => $response['scan_date'],
            'scans'    => $response['scans'],
        ];

        return view('url_results', $data);
    }

}
