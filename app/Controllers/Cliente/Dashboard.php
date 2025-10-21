<?php
namespace App\Controllers\Cliente;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('cliente/dashboard');
    }
}
?>