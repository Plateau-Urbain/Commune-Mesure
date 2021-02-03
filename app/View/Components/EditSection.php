<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditSection extends Component
{
    public $edit;

    /**
     * The section name.
     *
     * @var string
     */
    public $section;

    /**
     * The sections collection.
     *
     * @var Collection
     */
    public $sections;

    /**
     * Create the component instance.
     *
     * @param  string  $section
     * @param  bool  $visible
     * @return void
     */
    public function __construct($edit, $sections, $section)
    {
        $this->edit = $edit;
        $this->section = $section;
        $this->sections = $sections;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.place.edit-section');
    }
}
