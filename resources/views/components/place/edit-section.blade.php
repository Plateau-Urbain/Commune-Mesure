@if ($edit || ($hasSection && $sectionVisibility))
    <div
      @if ($edit && $sectionVisibility)
        {{ $attributes->merge(['class' => 'edit']) }}
      @elseif ($edit)
        {{ $attributes->merge(['class' => 'edit hidden']) }}
      @else
        {{ $attributes }}
      @endif
    >

        @if ($edit)
        <div class="icon-edit">
          <a href="{{ route('place.toggle', [
            'slug' => $attributes->get('slug'),
            'auth' => $attributes->get('auth'),
            'section' => $section
          ]) }}">
            @if ($sectionVisibility)
              <i class="fa fa-eye-slash" title="Cacher la section"></i>
            @else
              <i class="fa fa-eye" title="Afficher la section"></i>
            @endif
          </a>
        </div>

        <div class="icon-edit">
            <i class="fa fa-pen" title="Éditer la section"></i>
        </div>
        @endif

        {{ $slot }}
      </div>
<?php endif; ?>
