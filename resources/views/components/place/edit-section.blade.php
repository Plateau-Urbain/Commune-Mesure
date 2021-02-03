@if ($edit || ($hasSection && $sectionVisibility))
    @if ($edit && $sectionVisibility)
      <div class="edit" {{ $attributes }}>
    @elseif ($edit)
      <div class="edit hidden" {{ $attributes }}>
    @else
      <div {{ $attributes }}>
    @endif

        @if ($edit)
        <div class="icon-edit">
            {{ $url }}
            @if ($sectionVisibility)
              <i class="fa fa-eye-slash"></i>
            @else
              <i class="fa fa-eye"></i>
            @endif
          </a>
        </div>
        @endif

        {{ $slot }}
      </div>
<?php endif; ?>
