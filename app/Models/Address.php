<?php 
namespace App\Models;

class Address  
{
    public string $street;
    public string $city;
    public string $country;
    public string $postalcode;

    public function __construct(string $street, string $city, string $country, string $postalcode)
    {
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;
        $this->postalcode = $postalcode;
    }
}