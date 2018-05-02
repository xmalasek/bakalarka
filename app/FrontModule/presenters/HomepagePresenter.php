<?php

namespace FrontModule;

use Nette;


class HomepagePresenter extends BasePresenter
{
    public function __construct(Nette\Database\Context $database)
    {
        parent::__construct();
    }


    /**
     *
     */


    private $foo = 'any value';


    public function handleChangeFoo()
    {

      $this->foo = 'pokus';

      if ($this->isAjax()){

          $this->invalidateControl('pokus');


      }

    }


    public function renderDefault()
    {
        $this->template->foo = $this->foo;
    }
}
