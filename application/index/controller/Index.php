<?php
namespace app\index\controller;
use think\Controller;
use Workerman\Worker;
use GatewayWorker\Register;
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;

class Index extends Controller
{

    public function index(){
        $this->redirect('/admin/');
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
