<?php

use App\Exceptions\NotFoundException;
use App\Http\Helpers\Request;
use App\Http\Helpers\ResponseHandler;
use App\Tests\Dummies\DummyController;
use App\Utils\HttpStatusCode;
use App\Validators\ExceptionHandler;
use PHPUnit\Framework\TestCase;

class ExceptionHandlerTest extends TestCase
{
    private $controllerDummy;
    private $capturedResponse;
    private $capturedStatusCode;
    private $requestMock;
    private $exceptionHandler;
    private $controllerInstance;
    private $action;
    private $responseMock;

    protected function setUp(): void
    {
        $this->controllerDummy = new DummyController();
        $this->responseMock = $this->createMock(ResponseHandler::class);
        $this->exceptionHandler = new ExceptionHandler($this->responseMock);
    }

    //work correctly tests
    public function testIfWorksCorrectlyWithoutParameters()
    {
        $action = 'methodWithoutParameters';

        $this->exceptionHandler->handle($this->controllerDummy, $action);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
        $this->assertEmpty($this->controllerDummy->calledParams);
    }

    public function testIfWorksCorrectlyWithIntParamter()
    {
        $action = 'methodIfWorksWithIntParam';
        $param = 1;

        $this->exceptionHandler->handle($this->controllerDummy, $action, $param);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
        $this->assertEquals($param, $this->controllerDummy->calledParams[0]);
    }

    public function testIfWorksCorrectlyWithOneParameter()
    {
        $action = 'methodIfWorksWithOneParameter';
        $param = "testParameter";

        $this->exceptionHandler->handle($this->controllerDummy, $action, $param);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
        $this->assertEquals($param, $this->controllerDummy->calledParams[0]);
    }

    public function testIfWorksCorrectlyWithMultiplesParameters()
    {
        $action = 'methodIfWorksCorrectlyWithMultiplesParameters';
        $params = ["testParameter", 1];

        $this->exceptionHandler->handle($this->controllerDummy, $action, $params);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
        $this->assertEquals($params, $this->controllerDummy->calledParams);
    }

    public function testIfWorksCorrectlyWithRequestInstanceAndIntParameter()
    {
        $action = 'methodIfWorksCorrectlyWithRequestInstance';
        $params = [new Request(), '1'];
        $this->exceptionHandler->handle($this->controllerDummy, $action, $params);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
        $this->assertEquals($params, $this->controllerDummy->calledParams);
    }

    //exception catches tests
    public function testIfCatchesThrowableWithInvalidIntances()
    {
        $this->responseMock
            ->expects($this->once())
            ->method('json')
            ->with(
                $this->equalTo($this->responseData('error', "Method name must be a string")),
                $this->equalTo(HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR)
            );

        $this->exceptionHandler->handle(null, null);
    }

    public function testIfItCatchesNotFoundExceptionWithCorrectResponse()
    {
        $action = 'methodNotFoundException';

        $this->responseMock
            ->expects($this->once())
            ->method('json')
            ->with(
                $this->equalTo($this->responseData('error', "Not Found Exception")),
                $this->equalTo(HttpStatusCode::HTTP_NOT_FOUND)
            );
        $this->exceptionHandler->handle($this->controllerDummy, $action);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
    }

    public function testIfItCatchesNotFoundExceptionWithCorrectResponseWithOneParameter()
    {
        $action = 'methodNotFoundExceptionWithOneParam';
        $param = 'paramTest';
        $this->responseMock
            ->expects($this->once())
            ->method('json')
            ->with(
                $this->equalTo($this->responseData('error', "Not Found Exception With One Param")),
                $this->equalTo(HttpStatusCode::HTTP_NOT_FOUND)
            );
        $this->exceptionHandler->handle($this->controllerDummy, $action, $param);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
    }

    public function testIfItCatchesNotFoundExceptionWithCorrectResponseWithTwoParameters()
    {
        $action = 'methodNotFoundExceptionWithTwoParams';
        $params = ['paramTest1', 'paramTest2'];

        $this->responseMock
            ->expects($this->once())
            ->method('json')
            ->with(
                $this->equalTo($this->responseData('error', "Not Found Exception With Two Params")),
                $this->equalTo(HttpStatusCode::HTTP_NOT_FOUND)
            );
        $this->exceptionHandler->handle($this->controllerDummy, $action, $params);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
    }

    public function testIfThrowsGenericException()
    {
        $action = 'methodThrowsGenericException';

        $this->responseMock
            ->expects($this->once())
            ->method('json')
            ->with(
                $this->equalTo($this->responseData('error', "Exception throwed")),
                $this->equalTo(HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR)
            );
        $this->exceptionHandler->handle($this->controllerDummy, $action);

        $this->assertEquals($action, $this->controllerDummy->calledMethod);
        $this->assertEmpty($this->controllerDummy->calledParams);
    }

    private function responseData(string $status, string $message): array
    {
        return [
            'status' => $status,
            'message' => $message
        ];
    }
}