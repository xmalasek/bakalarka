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

    }

    public function renderShow()
    {
        $eletric = $this->database->table('eletric');
        $this->template->eletric = $eletric;


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
        $lat = $this->getHttpRequest()->getPost('lat');
        $lng = $this->getHttpRequest()->getPost('lng');



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
            'lat' => $lat,
            'lng' => $lng,
        ]);

    }

    public function handleGetUser() {

//        $data=$this->database->table('eletric');
//
//        $array = $this->database->table('eletric')->fetchPairs($data);
//
//        $value = Json::encode($array, Json::PRETTY);
//
//        $this->sendJson($value);
//
//
//        $select = $this->database->table('eletric');
//
//        $rows = array();
//
//        while($r = $select->fetchAssoc("id")) {
//            $rows[] = $r;
//        }






//        $result = $this->database->query('SELECT * FROM eletric');


        $select = $this->database->table('eletric');

        $rows = array();

        while($r = $select->fetch(\PDO::FETCH_ASSOC)) {
            $rows[] = $r;
        }

        print Json::encode($rows);





    }
}