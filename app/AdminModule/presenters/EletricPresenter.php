<?php

namespace AdminModule;

use Nette;


class EletricPresenter extends BasePresenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    public function renderDefault()
    {

    }

    // TODO zmenit dle vrtsvy handle*****
    public function handleInsertUser() {

        $values = $this->getHttpRequest()->getPost('name');
        $email = $this->getHttpRequest()->getPost('email');
        $website = $this->getHttpRequest()->getPost('website');
        $city = $this->getHttpRequest()->getPost('city');
        $lat = $this->getHttpRequest()->getPost('lat');
        $lng = $this->getHttpRequest()->getPost('lng');

        $this->database->table('eletric')->insert([
            'nazev' => $values ,
            'typ' => $email,
            'oznaceni' => $website,
            'popis' => $city,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

    }

    public function handleGetUser() {





    }
}