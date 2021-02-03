@if ($edit || ($hasSection && $sectionVisibility))
    @if ($edit && $sectionVisibility)
      <div class="edit">
    @elseif ($edit)
      <div class="edit hidden">
    @else
      <div>
    @endif

        @if ($edit)
        <div class="is-pulled-right mx-2">
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
