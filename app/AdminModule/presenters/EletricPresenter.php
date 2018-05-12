<?php

namespace AdminModule;

use Nette;
use Nette\Application\Responses\JsonResponse;
use Nette\Utils\Json;
use Tracy\Debugger;

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

    public function renderShow()
    {
        $this->template->eletric = $this->database->table('eletric');

    }

    public function renderAdd()
    {


    }

    public function renderInfo($deviceId){



        $device = $this->database->table('eletric')->where('id', $deviceId);

        if (!$device) {
            $this->error('Příspěvek nebyl nalezen');
        }else{

            $this->template->eletric = $device;

        }



    }

    public function handleAdd() {

        $lat = $this->getHttpRequest()->getPost('lat');

        $lng = $this->getHttpRequest()->getPost('lng');

        $this->database->table('pokus')->insert([
            'x' => $lat ,
            'y' => $lng,
        ]);

    }



    // TODO zmenit dle vrtsvy handle*****
//    public function handleInsertUser() {
//
//        //TODO isAjax nette manual
//
//
//        $nazev = $this->getHttpRequest()->getPost('nazev');
//        $ulice = $this->getHttpRequest()->getPost('ulice');
//        $typ = $this->getHttpRequest()->getPost('typ');
//        $svitidlo = $this->getHttpRequest()->getPost('svitidlo');
//        $oznaceni = $this->getHttpRequest()->getPost('oznaceni');
//        $pocet = $this->getHttpRequest()->getPost('pocet');
//        $stav = $this->getHttpRequest()->getPost('stav');
//        $stozar = $this->getHttpRequest()->getPost('stozar');
//        $popis = $this->getHttpRequest()->getPost('popis');
//        $lat = $this->getHttpRequest()->getPost('lat');
//        $lng = $this->getHttpRequest()->getPost('lng');
//
//
//
//        $this->database->table('eletric')->insert([
//            'nazev' => $nazev ,
//            'ulice' => $ulice,
//            'typ' => $typ,
//            'svitidlo' => $svitidlo,
//            'oznaceni' => $oznaceni,
//            'pocet' => $pocet,
//            'stav' => $stav,
//            'stozar' => $stozar,
//            'popis' => $popis,
//            'lat' => $lat,
//            'lng' => $lng,
//        ]);
//
//    }


    protected function createComponentInsertEletricForm(){

        $form = (new InsertEletricFormFactory()) -> create();
        $form['lat']->setValue($_POST["lat"]);
        $form['lng']->setValue($_POST["lng"]);
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];
        $this->flashMessage('Položka byla přidána.');
        return $form;


    }

    public function insertDeviceSucceeded($form, $values){

        $deviceId = $this->getParameter('deviceId');

        if ($deviceId) {
            $post = $this->database->table('posts')->get($deviceId);
            $post->update($values);
        } else {

        $this->database->table('eletric')->insert([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'typ' => $values->typ,
            'svitidlo' => $values->svitidlo,
            'oznaceni' => $values->oznaceni,
            'pocet' => $values->pocet,
            'stav' => $values->stav,
            'stozar' => $values->stozar,
            'popis' => $values->popis,
            'lat' => $values->lat,
            'lng' => $values->lng,
        ]);

        }

        $this->flashMessage('Příspěvek byl úspěšně publikován.', 'success');

        $this->redirect('Eletric:');


    }

    public function actionEdit($deviceId){

        $device = $this->database->table('eletric')->get($deviceId);
        if (!$device) {
            $this->error('Příspěvek nebyl nalezen');
        }


        $form = (new InsertEletricFormFactory()) -> create();
        $devices = $this->database->table('eletric')->where('field', $device);

        $form['nazev']->setDefaultValue($devices->nazev);




    }

    public function handleDelete($deviceId){

        $this->database->table('eletric')->where('id', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'success');

    }



}