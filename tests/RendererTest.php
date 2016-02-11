<?php

use MartynBiz\Slim3View\Renderer;

use Slim\Http\Response;

class RendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Windwalker\Renderer\AbstractEngineRenderer_mock
     */
    protected $phpRendererMock;

    public function setUp()
    {
        // Create a mock renderer to pass to our Renderer, any will do
        $this->phpRendererMock = $this->getMockBuilder('Windwalker\\Renderer\\PhpRenderer')
             ->disableOriginalConstructor()
             ->getMock();

        // Create a mock renderer to pass to our Renderer, any will do
        $this->responseMock = $this->getMockBuilder('Slim\\Http\\Response')
            ->disableOriginalConstructor()
            ->getMock();

       // Create a mock renderer to pass to our Renderer, any will do
       $this->responseBodyMock = $this->getMockBuilder('Slim\\Http\\Stream')
           ->disableOriginalConstructor()
           ->getMock();
    }

    public function test_initialization()
    {
        $renderer = new Renderer($this->phpRendererMock);

        $this->assertTrue($renderer instanceof Renderer);
    }

    public function test_render_method_calls_renderer_render_method_with_args()
    {
        $renderer = new Renderer($this->phpRendererMock);

        $this->phpRendererMock
            ->expects( $this->once() )
            ->method('render')
            ->with('path/to/template.phtml', array(
                'name' => 'Martyn',
            ));

        $this->responseMock
            ->expects( $this->once() )
            ->method('getBody')
            ->willReturn( $this->responseBodyMock );

        $this->responseBodyMock
            ->expects( $this->once() )
            ->method('write');

        $renderer->render($this->responseMock, 'path/to/template.phtml', array(
            'name' => 'Martyn',
        ));
    }
}
