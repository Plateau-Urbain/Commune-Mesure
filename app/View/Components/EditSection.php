<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditSection extends Component
{
    /**
     * Are we in edition mode
     *
     * @var bool
     */
    public $edit;

    /**
     * The section visibility
     *
     * @var bool
     */
    public $sectionVisibility;

    /**
     * The section name
     *
     * @var string
     */
    public $section;

    /**
     * Create the component instance.
     *
     * @param  bool  $edit Edition mode
     * @param  Collection  $sections All the sections
     * @param  string $section The section name
     * @return void
     */
    public function __construct($edit, $sections, $section)
    {
        $this->edit = $edit;
        $this->section = $section;
        $this->sectionVisibility = (bool) $sections[$section];

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
