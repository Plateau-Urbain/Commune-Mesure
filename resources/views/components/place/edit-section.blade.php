@if ($edit || ($sections->has($section) && $sections->get($section)))
  <section class="section" id="{{ $section }}">
    @if ($edit && $sections->get($section))
      <div class="edit">
    @elseif ($edit)
      <div class="edit hidden">
    @else
      <div>
    @endif

        @if ($edit)
        <div class="is-pulled-right mx-2">
            {{ $url }}
            @if ($sections->get($section))
              <i class="fa fa-eye-slash"></i>
            @else
              <i class="fa fa-eye"></i>
            @endif
          </a>
        </div>
        @endif

        {{ $slot }}
      </div>
  </section>
<?php endif; ?>
