<?php

namespace AdminModule;

use Nette;
use Nette\Utils\Json;


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
        $this->template->eletric = $this->database->table('eletric');
    }

    // TODO zmenit dle vrtsvy handle*****
    public function handleInsertUser() {

        $nazev = $this->getHttpRequest()->getPost('nazev');
        $ulice = $this->getHttpRequest()->getPost('ulice');
        $typ = $this->getHttpRequest()->getPost('typ');
        $svitidlo = $this->getHttpRequest()->getPost('svitidlo');
        $oznaceni = $this->getHttpRequest()->getPost('oznaceni');
        $pocet = $this->getHttpRequest()->getPost('pocet');
        $stav = $this->getHttpRequest()->getPost('stav');
        $stozar = $this->getHttpRequest()->getPost('stozar');
        $popis = $this->getHttpRequest()->getPost('popis');
        $latitude = $this->getHttpRequest()->getPost('latitude');
        $longitude = $this->getHttpRequest()->getPost('longitude');



        $this->database->table('eletric')->insert([
            'nazev' => $nazev ,
            'ulice' => $ulice,
            'typ' => $typ,
            'svitidlo' => $svitidlo,
            'oznaceni' => $oznaceni,
            'pocet' => $pocet,
            'stav' => $stav,
            'stozar' => $stozar,
            'popis' => $popis,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

    }

    public function handleGetUser() {



        $this->template->eletric = $this->database->table('eletric');

        $result = $this->database->table('eletric');

        $row = $result->fetch();

        print Json::encode($row);








    }
}