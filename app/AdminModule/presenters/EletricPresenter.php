<?php

namespace AdminModule;

use Nette;
use Nette\Application\Responses\JsonResponse;
use Nette\Utils\Json;
use function PHPSTORM_META\type;
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


    public function renderFault()
    {


    }

    public function actionFault($id){

        $this['insertFaultForm']->setDefaults([
            'id_device' => $id
        ]);

    }

    public function renderInfo($id){
        $this->template->eletric = $this->database->table('eletric')->where('id_eletric', $id);
    }

    public function actionInfo($id){
        $device = $this->database->table('eletric')->get($id);

        if (!$device) {
            $this->flashMessage('Položka nebyla nalezena.', 'fail');
            $this->redirect(':Admin:Eletric:default');
        }
    }


    protected function createComponentInsertEletricForm(){

        $form = (new InsertEletricFormFactory()) -> create();
        $form['lat']->setValue($_POST["lat"]);
        $form['lng']->setValue($_POST["lng"]);
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];

//        $this->flashMessage('Položka byla přidána.');
        return $form;


    }

    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertEletricFaultSucceeded'];
        return $form;

    }



    public function insertDeviceSucceeded($form, $values){

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
        $this->flashMessage('Položka byla úspěšně přidána.', 'info');
        $this->redirect('Eletric:default');
    }

    public function insertEletricFaultSucceeded($form, $values){

        $data=
            ['description' => $values->description ,
            'datum' => $values->datum,
            'email' => $values->email,
            ];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('eletric')
            ->where('id_eletric', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);
       $this->flashMessage('Závada byla nahlášena.', 'info');
       $this->redirect('Eletric:default');

    }

    protected function createComponentEditEletricForm(){

        $form = (new EditEletricFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'updateDeviceSucceeded'];

        return $form;
    }

    public function updateDeviceSucceeded($form, $values){

        $this->database->table('eletric')
            ->where('id_eletric', $this->getParameter('id')) // must be called before update()
            ->update([

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

        $this->flashMessage('Položka byla úspěšně editována.', 'info');

    }

    public function actionEdit($id){

        $values = $this->database->table('eletric')->get($id);
        if (!$values) {
            $this->flashMessage('Položka nebyla nalezena.', 'fail');
            $this->redirect(':Admin:Eletric:default');
        }

        $this['editEletricForm']->setDefaults([
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

    public function handleDelete($deviceId){

        $this->database->table('eletric')->where('id_eletric', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'info');

    }



}