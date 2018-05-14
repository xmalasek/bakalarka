<?php

namespace FrontModule;

use Nette;


class InterestPresenter extends Nette\Application\UI\Presenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
        $this->database = $database;

    }

    public function renderDefault()
    {
        $this->template->interest = $this->database->table('interest');
    }

    public function renderShow()
    {
        $this->template->interest = $this->database->table('interest');


    }

    public function renderFault()
    {


    }


    public function actionFault($id){

        $this['insertFaultForm']->setDefaults([
            'id_device' => $id
        ]);

    }

    protected function createComponentInsertFaultForm(){

        $form = (new InsertFaultFormFactory()) -> create();
        $form->onSuccess[] = [$this, 'insertInterestFaultSucceeded'];
        return $form;

    }

    public function insertInterestFaultSucceeded($form, $values){

        $data=
            ['description' => $values->description ,
                'datum' => $values->datum];

        $error_id = $this->database->table('error')->insert($data)->id_error;

        $this->database->table('interest')
            ->where('id_interest', $values->id_device)
            ->update([
                'error_id' => $error_id
            ]);

        $this->redirect('Interest:default');

    }
}