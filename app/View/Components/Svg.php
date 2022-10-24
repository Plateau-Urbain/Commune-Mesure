<?php

namespace App\View\Components;

use DOMDocument;
use Illuminate\View\Component;

class Svg extends Component
{
    /**
     * Le svg créé
     *
     * @var \DOMDocument
     */
    public $svg;

    /**
     * Create the component instance.
     *
     * @param  string $path Le chemin du svg
     * @param  string  $class Classes du svg
     * @param  string  $transform transform fonction
     * @param  int $width Largeur du svg
     * @param  int $height Hauteur du svg
     * @return void
     */
    public function __construct($path, $class, $transform, $width, $height)
    {
        $this->svg = new DOMDocument();
        $this->svg->load(resource_path($path));
        $this->svg->documentElement->setAttribute("class", $class);
        $this->svg->documentElement->setAttribute("transform", $transform);
        $this->svg->documentElement->setAttribute("width", $width);
        $this->svg->documentElement->setAttribute("height", $height);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return function (array $data) {
            if ($data['slot']->isNotEmpty()) {
                $el = new DOMDocument();
                $el->loadXML($data['slot']->toHTML());

                $new = $this->svg->importNode($el->documentElement, true);
                $g = $this->svg->createElement('g');
                $g->setAttribute("transform", "translate(80,200)");
                $g->setAttribute("width", "50%");
                $g->appendChild($new);

                $this->svg->documentElement->appendChild($g);
            }
            return $this->svg->saveXML($this->svg->documentElement);//.$data['slot'];
        };
    }
}
