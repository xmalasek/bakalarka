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

    }

    public function renderShow()
    {
        $waste = $this->database->table('waste');
        $this->template->waste = $waste;


    }
}