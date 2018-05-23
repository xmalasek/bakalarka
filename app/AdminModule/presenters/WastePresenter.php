<?php

namespace AdminModule;

use Nette;
use Nette\Utils\FileSystem;


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
        $this->myRenderDefault(null);
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

        $waste = $this->database->table('waste')->get($this->getParameter('id'));
        $avatar = $values->avatar;
        if($avatar->isImage() and $avatar->isOk()) {
            if (!is_null($waste->avatar)) {
                FileSystem::delete('admin/upload/waste/'.$waste->avatar);
            }

            $file_ext=strtolower(mb_substr($avatar->getSanitizedName(), strrpos($avatar->getSanitizedName(), ".")));
            $file_name = $waste->id_waste . $file_ext;
            $avatar->move('admin/upload/waste/'. $file_name);
            $values->avatar = $file_name;
        }
        else {
            $values->avatar = $waste->avatar;
        }

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

        if(is_null($values->avatar)) {
            $this->template->avatar_path = '';
        }
        else {
            $this->template->avatar_path = '/admin/upload/waste/'.$values->avatar;
        }


    }

    public function handleDelete($deviceId){

        $waste = $this->database->table('waste')->get($deviceId);
        if(!is_null($waste->avatar))
        {
            FileSystem::delete('admin/upload/waste/'.$waste->avatar);
        }
        $this->database->table('waste')->where('id_waste', $deviceId)->delete();
        $this->flashMessage('Zařízení bylo úspěšně odstraněno.', 'info');
    }

    protected function createComponentFiltrWasteForm(){

        $form = (new FiltrWasteFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'filtrDeviceSucceeded'];

        return $form;
    }

    private function myRenderDefault($value) {
        if(!isset($this->template->waste))
        {
            if(!$value)
            {
                $this->template->waste = $this->database->table('waste');
            }
            else {
                $this->template->waste = $this->database->table('waste')->where('ulice', $value);
            }
        }
    }

    public function filtrDeviceSucceeded($form, $values){
        $this->myRenderDefault($values->ulice);
    }

}