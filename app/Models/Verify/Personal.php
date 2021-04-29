<?php

namespace App\Models\Verify;

use DateTime;

/**
 * Class ApiModel
 * @package App\Models\SMS
 */
class Personal
{
    /**
     * @var DateTime|null
     */
    private $date = null;
    /**
     * @var string|null
     */
    private $inn = null;

    /**
     * Personal constructor.
     * @param string $inn
     * @param null $date
     */
    public function __construct(string $inn, $date = null)
    {
        if (!$date) {
            $this->date = new DateTime("now");;
        }

        $this->inn = $inn;
    }

    /**
     * @return DadataClient
     */
    public function get()
    {
        $dateStr = $this->date->format("Y-m-d");
        $url = "https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status";
        $data = array(
            "inn" => $this->inn,
            "requestDate" => $dateStr
        );
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => array(
                    'Content-type: application/json',
                ),
                'content' => json_encode($data)
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result);
    }
}
