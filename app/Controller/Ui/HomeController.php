<?php

namespace App\Controller\Ui;

use Hyperf\HttpServer\Annotation\{Controller, GetMapping};
use Hyperf\ViewEngine\Contract\ViewInterface;

use function Hyperf\ViewEngine\view;

#[Controller]
class HomeController
{
    #[GetMapping('/')]
    public function home(): ViewInterface
    {
        return view('home', ['name' => 'Rodrigo']);
    }
}
