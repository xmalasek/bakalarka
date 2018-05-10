<?php

namespace AdminModule;

use Nette;


class InterestPresenter extends BasePresenter
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
        $interest = $this->database->table('interest');
        $this->template->interest = $interest;


    }
}