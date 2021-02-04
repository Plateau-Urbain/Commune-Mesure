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
            {{ $url }}
            @if ($sectionVisibility)
              <i class="fa fa-eye-slash" title="Cacher la section"></i>
            @else
              <i class="fa fa-eye" title="Afficher la section"></i>
            @endif
          </a> {{-- <a> starts in {{ $url }} --}}
        </div>
        @endif

        {{ $slot }}
      </div>
<?php endif; ?>
