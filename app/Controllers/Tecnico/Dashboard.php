<?php
namespace App\Controllers\Tecnico;
use App\Controllers\BaseController;
class Dashboard extends BaseController
{
    public function index()
    {
        return view('tecnico/dashboard');
    }
}
?>