<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ConstantReachApiService
{
    private function request()
    {
        return Http::acceptJson()
            ->withToken(config('services.remote_api.token'))
            ->timeout(20);
    }

    /**
     * Get CAPTCHA from constantemails.com
     */
    public function getCaptcha()
    {
        return $this->request()->get(
            rtrim(config('services.remote_api.url'), '/') . '/contact-captcha'
        );
    }

    /**
     * Submit contact enquiry to constantemails.com
     */
    public function submitEnquiry(array $data)
    {
        return $this->request()->post(
            rtrim(config('services.remote_api.url'), '/') . '/contact-enquiries',
            $data
        );
    }
}
