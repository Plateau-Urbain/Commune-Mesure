@if ($edit || ($sectionVisibility))
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
        <div class="icon-edit toggle">
          <a href="{{ route('place.toggle', [
            'slug' => $attributes->get('slug'),
            'auth' => $attributes->get('auth'),
            'section' => $section
          ]) }}">
            @if ($sectionVisibility)
              <i class="fa fa-eye" title="Cacher la section"></i>
            @else
              <i class="fa fa-eye-slash" title="Afficher la section"></i>
            @endif
          </a>
          @if ($isEmpty)
            <i class="fa fa-exclamation-triangle has-text-warning-dark" title="Les données sont vides"></i> Les données sont vides
          @endif
        </div>
        @endif

        {{ $slot }}
      </div>
<?php endif; ?>
