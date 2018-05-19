<?php

namespace AdminModule;

use Nette;


class WastePresenter extends BasePresenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;

    }

    public function renderDefault()
    {
        $this->template->waste = $this->database->table('waste');
    }

    public function renderShow()
    {
        $this->template->waste = $this->database->table('waste');


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

        $device = $this->database->table('waste')->where('id_waste', $id);

        if (!$device) {
            $this->error('Příspěvek nebyl nalezen');
            $this->redirect('Waste:default');
        }else{
            $this->template->waste = $device;
        }
    }


    protected function createComponentInsertWasteForm(){

        $form = (new InsertWasteFormFactory()) -> create();
        $form['lat']->setValue($_POST["lat"]);
        $form['lng']->setValue($_POST["lng"]);
        $form->onSuccess[] = [$this, 'insertDeviceSucceeded'];
        return $form;
    }

    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertWasteFaultSucceeded'];
        return $form;
    }

    public function insertDeviceSucceeded($form, $values){

        $this->database->table('waste')->insert([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'typ' => $values->typ,
            'oznaceni' => $values->oznaceni,
            'pocet' => $values->pocet,
            'stav' => $values->stav,
            'objem' => $values->objem,
            'popis' => $values->popis,
            'lat' => $values->lat,
            'lng' => $values->lng,

        ]);
        $this->redirect('Waste:');
    }

    public function insertWasteFaultSucceeded($form, $values){

        $data=
            ['description' => $values->description ,
                'datum' => $values->datum,
                'email' => $values->email,
            ];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('waste')
            ->where('id_waste', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Waste:default');

    }

    protected function createComponentEditWasteForm(){

        $form = (new EditWasteFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'updateDeviceSucceeded'];

        return $form;
    }

    public function updateDeviceSucceeded($form, $values){

        $this->database->table('waste')
            ->where('id_waste', $this->getParameter('id')) // must be called before update()
            ->update([

                'nazev' => $values->nazev ,
                'ulice' => $values->ulice,
                'typ' => $values->typ,
                'oznaceni' => $values->oznaceni,
                'pocet' => $values->pocet,
                'stav' => $values->stav,
                'objem' => $values->objem,
                'popis' => $values->popis,
                'lat' => $values->lat,
                'lng' => $values->lng,

            ]);

        $this->flashMessage('Položka byla úspěšně editována.');

    }

    public function actionEdit($id){

        $values = $this->database->table('waste')->get($id);
        if (!$values) {
            $this->error('Příspěvek nebyl nalezen');
        }

        $this['editWasteForm']->setDefaults([
            'nazev' => $values->nazev ,
            'ulice' => $values->ulice,
            'typ' => $values->typ,
            'oznaceni' => $values->oznaceni,
            'pocet' => $values->pocet,
            'stav' => $values->stav,
            'objem' => $values->objem,
            'popis' => $values->popis,
            'lat' => $values->lat,
            'lng' => $values->lng,

        ]);


    }

    public function handleDelete($deviceId){

        $this->database->table('waste')->where('id_waste', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'info');

    }

}