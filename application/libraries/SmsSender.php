<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SmsSender {

    private $max_retries = 1; // Number of retry attempts

    /**
     * Send SMS via Mobi API with retry and logging
     */
    public function send_sms_with_mobi($key, $contact_no, $msg)
    {
        // 1️⃣ Sanitize phone number (only digits, international format)
        $phone = preg_replace('/\D/', '', $contact_no);
        if (strlen($phone) < 10) {
            log_message('error', 'SMS failed: Invalid phone number: '.$contact_no);
            return ['success' => false, 'response' => 'Invalid phone number'];
        }

        $postData = [
            'api_key'      => $key,
            'phone_number' => $phone,
            'msg_text'     => $msg
        ];

        $attempt = 0;
        do {
            $attempt++;
            $response = $this->call_api($postData);

            // Extract JSON from response
            $json_response = $this->extract_json_from_response($response);
            $re = json_decode($json_response, true);

            // Log everything
            log_message('info', "SMS Attempt {$attempt} | POST: ".json_encode($postData)." | Response: ".$response);

            // Check if SMS sent successfully (accept both 'success' and 'ok')
				if (isset($re['stt']) && ($re['stt'] === 'success' || $re['stt'] === 'ok')) {
					return ['success' => true, 'response' => $re];
				}
            // Wait 1 second before retry
            sleep(1);

        } while ($attempt < $this->max_retries);

        // Final failure
        return ['success' => false, 'response' => $re ?? $response];
    }

    /**
     * Make CURL call to API
     */
    private function call_api($postData)
    {
        $ch = curl_init("https://backup.introps.com/Sms_common/send_sms");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);

        if ($response === false) {
            $response = curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }

    /**
     * Extract JSON from response (handles extra text before JSON)
     */
    private function extract_json_from_response($response)
    {
        if ($this->is_json($response)) {
            return $response;
        }

        preg_match('/\{(?:[^{}]|(?R))*\}/', $response, $matches);
        if (!empty($matches[0])) return $matches[0];

        preg_match('/\[(?:[^\[\]]|(?R))*\]/', $response, $matches);
        if (!empty($matches[0])) return $matches[0];

        return $response;
    }

    /**
     * Check if string is valid JSON
     */
    private function is_json($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
}
?>
