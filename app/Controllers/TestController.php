<?php

namespace app\Controllers;

use service\Viewer;

class TestController
{
    public function test()
    {
        Viewer::view('testPage');
    }
}