<?php
declare(strict_types = 1);
class Shortner
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    private function isValidUrl(string $url): bool|string
    {
        return (filter_var($url, FILTER_VALIDATE_URL));
    }

    private function generateShortCode(): string
    {
        $chars = 'qwertyuiopasdfghjklzxcvbnm';
        $code = '';

        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $code;
    }

    public function redirect(string $code)
    {
        $url = $this->db->getLink($code);

        return $url['long_url'];
    }

    public function short(string $link): string
    {
       if(!$this->isValidUrl($link)){
           throw new Exception("Not a valid url");
       }

       $shortCode = $this->generateShortCode();
       $this->db->insertLink($link, $shortCode);

       return $shortCode;
    }


}