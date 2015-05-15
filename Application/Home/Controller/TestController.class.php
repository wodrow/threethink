<?php
namespace Home\Controller;
class TestController extends HomeController {

    public function _initialize()
    {
        echo C('APP_VERSION');
        parent:: _initialize();
    }

    public function index(){
        header("location:".U(test));
        // echo C('APP_VERSION');
    }

    public function test()
    {
        W("Test/test");
    }

    // baidu share test
    public function test1()
    {
        $this->display();
    }

    // game Surrounding nerve cat
    public function test2()
    {
        $this->display();
    }

    // canvas test
    public function test3()
    {
        $this->display();
    }

    // html sound vedio
    public function test4()
    {
        $this->display();
    }

    // widget test
    public function test5()
    {
        $this->display();
    }

    // canvas clock
    public function tset6()
    {
        $this->display();
    }

    // canvas solar system
    public function test7()
    {
        $this->display();
    }

    // canvas solar system2
    public function test8()
    {
        $this->display();
    }

    // canvas Photo Editor
    public function test9()
    {
        $this->display();
    }

    // canvas photo editor2
    public function test10()
    {
        $this->display();
    }

    // canvas photo editor3
    public function test11()
    {
        $this->display();
    }
}