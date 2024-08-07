<?php

namespace App\Services\Jobs;

use App\Models\Job;
use Google_Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleIndexingService {
    /**
     * Notify Google Indexing about the job update
     * @param App\Models\Job $job Job being updated
     * @return bool
     */
    public static function updateJobIndexing(Job $job) : bool
    {
        $job_url = route('website.job.details', $job->slug);
        return self::notifyGoogleIndexing($job_url, "URL_UPDATED");
    }

    /**
     * Notify Google Indexing about the job deletion
     * @param App\Models\Job $job Job being deleted
     * @return bool
     */
    public static function deleteJobIndexing(Job $job)
    {
        $job_url = route('website.job.details', $job->slug);
        return self::notifyGoogleIndexing($job_url, "URL_DELETED");
    }

    /**
     * call Google Indexing API with JobPosting update
     * @param string $job_url URL of the jon in site
     * @param string $type Type of request (Possibly, URL_UPDATED or URL_DELETED)
     * @return bool
     */
    private static function notifyGoogleIndexing(string $job_url, string $type = "URL_UPDATED")
    {
        $accessToken = env("GOOGLE_JOB_INDEXING_ACCESS_TOKEN"); //  'YOUR_ACCESS_TOKEN';
        $apiEndpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';

        // if access token in empty or not found
        if (empty($accessToken)) {
            Log::error(
                "JOB_INDEXING_ERROR: \n\t"
                    . "GOOGLE_JOB_INDEXING_ACCESS_TOKEN environment variable is not defined."
            );
            return false;
        }

        $data = [
            'url' => $job_url,
            'type' => $type
        ];

        try {
            // send request to google with new indexing info
            $response = Http::withHeaders([
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json'
            ])->post($apiEndpoint, $data);

            // success if received a response of HTTP 200, otherwise failed
            if ($response->successful()) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            $error_message = $th->getMessage();
            Log::error("JOB_INDEXING_ERROR: " . $error_message);
            return false;
        }
    }
}
