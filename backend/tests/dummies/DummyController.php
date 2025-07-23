<?php

namespace App\Tests\Dummies;

use App\Exceptions\NotFoundException;
use App\Http\Helpers\Request;
use Exception;

class DummyController
{

    public $calledMethod = null;
    public $calledParams;

    public function methodWithoutParameters(): void
    {
        $this->calledMethod = 'methodWithoutParameters';
        $this->calledParams = func_get_args();
    }

    public function methodIfWorksWithOneParameter(string $param): void
    {
        $this->calledMethod = 'methodIfWorksWithOneParameter';
        $this->calledParams = func_get_args();
    }

    public function methodIfWorksWithIntParam(int $param): void
    {
        $this->calledMethod = 'methodIfWorksWithIntParam';
        $this->calledParams = func_get_args();
    }

    public function methodIfWorksCorrectlyWithRequestInstance(Request $request, int $num): void
    {
        $this->calledMethod = 'methodIfWorksCorrectlyWithRequestInstance';
        $this->calledParams = func_get_args();
    }

    public function methodIfWorksCorrectlyWithMultiplesParameters(string $param1, int $param2): void
    {
        $this->calledMethod = 'methodIfWorksCorrectlyWithMultiplesParameters';
        $this->calledParams = func_get_args();
    }

    public function methodNotFoundException(): never
    {
        $this->calledMethod = 'methodNotFoundException';
        $this->calledParams = func_get_args();

        throw new NotFoundException("Not Found Exception");
    }

    public function methodNotFoundExceptionWithOneParam($param = []): never
    {
        $this->calledMethod = 'methodNotFoundExceptionWithOneParam';
        $this->calledParams = func_get_args();

        throw new NotFoundException("Not Found Exception With One Param");
    }

    public function methodNotFoundExceptionWithTwoParams($params): never
    {
        $this->calledMethod = 'methodNotFoundExceptionWithTwoParams';
        $this->calledParams = func_get_args();

        throw new NotFoundException("Not Found Exception With Two Params");
    }

    public function methodThrowsGenericException(): never
    {
        $this->calledMethod = 'methodThrowsGenericException';
        $this->calledParams = func_get_args();

        throw new Exception("Exception throwed");
    }

    
}