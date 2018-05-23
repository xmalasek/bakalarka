<?php

namespace FrontModule;

use Nette;


class WastePresenter extends Nette\Application\UI\Presenter
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

    public function renderFault()
    {


    }


    public function actionFault($id){

        $this['insertFaultForm']->setDefaults([
            'id_device' => $id
        ]);

    }

    public function renderInfo($id){
        $this->template->waste = $this->database->table('waste')->where('id_waste', $id);
    }

    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertWasteFaultSucceeded'];
        return $form;

    }

    public function insertWasteFaultSucceeded($form, $values){

        $data=
            ['description' => $values->description ,
                'datum' => $values->datum,
                'email' => $values->email
            ];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('waste')
            ->where('id_waste', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Waste:default');

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