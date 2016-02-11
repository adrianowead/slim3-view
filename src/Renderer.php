<?php
/**
 * A wrapper for Slim3 renderer which uses Windwalker renderer (Blade, Twig, PHP etc)
 * @author Martyn Bissett
 */
namespace MartynBiz\Slim3View;

use Psr\Http\Message\ResponseInterface;
use Windwalker\Renderer\RendererInterface;

/**
 * Php View
 *
 * Render PHP view scripts into a PSR-7 Response object
 */
class Renderer
{
    /**
     * The renderer to use for the templates
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * SlimRenderer constructor.
     *
     * @param string $templatePath
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * Render a template
     * @param \ResponseInterface $response
     * @param                    $template
     * @param array              $data
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, array $data = [])
    {
        ob_start();
        echo $this->renderer->render($template, $data);
        $output = ob_get_clean();

        $response->getBody()->write($output);

        return $response;
    }
}
