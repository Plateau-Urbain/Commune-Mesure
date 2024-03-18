@if ($edit || ($sectionVisibility))
    <div
      @if ($edit)
        {{ $attributes->merge(['class' => 'edit']) }}
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
          <h2>{{$section}}</h2>
          @if ($isEmpty)
            <i class="fa fa-exclamation-triangle has-text-warning-dark" title="Les données sont vides"></i> Les données sont vides
          @endif
        </div>
        @endif

        <div class="{{!$sectionVisibility ? "hidden" : ""}}">
          {{ $slot }}
        </div>
      </div>
<?php endif; ?>
