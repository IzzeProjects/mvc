<?php

namespace Src\Services;

class Bar implements Foo
{


    private $request;

    public function test(): string
    {
        var_dump($this->request);
        return 'bar test invoked';
    }
}