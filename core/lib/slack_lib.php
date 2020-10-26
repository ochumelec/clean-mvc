<?php

class Slack {
    private $api_url = 'https://hooks.slack.com/XXXXXXXXX';

    public function __construct()
    {
    }

    public function send_msg($from, $to, $icon, $text)
    {
        $data = array(
            'text' => $text,
            'channel'=> $to,
            'username' => $from,
            'icon_emoji'=> $icon,
            'link_names' => true,
            'mrkdwn' => true
        );

        return $this->curl($data);

    }

    public function curl($data)
    {
        try {
            if (!$data) {
                throw new Exception('no data');
            }


            $ch = curl_init($this->api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);


            $ch = curl_init($this->api_url);
            curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => json_encode($data)
            ));
            $result = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);


            if ($info['http_code'] != 200) {
                throw new Exception('connection error');
            }

            return $result;

        } catch (Exception $e) {
            return array(
                'status' => 'error',
                'message' => $e->getMessage(),
            );
        }

    }
}
