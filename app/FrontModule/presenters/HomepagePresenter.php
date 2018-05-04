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
        $name = $this->context->getService('name');
        $email = $this->context->getService('email');
        $website = $this->context->getService('website');
        $city = $this->context->getService('city');
        $lat = $this->context->getService('lat');
        $lng = $this->context->getService('lng');

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
