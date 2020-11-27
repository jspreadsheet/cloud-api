<?php
namespace jexcel;

trait License
{
    /**
     * @return array
     */
    public function createCertificate($domain)
    {
        if (! $domain) {
            return [
                'error' => 1,
                'domain' => 'Domain not specified',
            ];
        }

        return $this->get('license/create/' . $domain);
    }
}