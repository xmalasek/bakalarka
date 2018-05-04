<?php

namespace FrontModule;

use Nette;


class HomepagePresenter extends BasePresenter
{
    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
    }

    public function renderDefault()
    {

    }

    public function handleDeletePic() {
        $name = $this->context->httpRequest->getPost('name');
        $email = $this->context->httpRequest->getPost('email');
        $website = $this->context->httpRequest->getPost('website');
        $city = $this->context->httpRequest->getPost('city');
        $lat = $this->context->httpRequest->getPost('lat');
        $lng = $this->context->httpRequest->getPost('lng');

        $this->database->table('lampiony')->insert([
            'nazev' => $name,
            'typ' => $email,
            'oznaceni' => $website,
            'popis' => $city,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

    }
}
