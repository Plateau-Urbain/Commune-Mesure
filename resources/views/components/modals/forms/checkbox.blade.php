
@if($value !== null)
  @if(isset($possible_values) && $possible_values !== null)
    @foreach($possible_values as $key => $v)
      <div class="field is-horizontal">
        <label class="checkbox">
          <input type="checkbox" name="{{ $name }}[{{ $key }}]"{{ (in_array($v, array_values($value))) ? ' checked' : '' }}>
          {{ $v }}
        </label>
      </div>
    @endforeach
  @else
    @foreach($value as $v => $checked)
    <div class="field is-horizontal">
      <label class="checkbox">
        <input type="checkbox" name="{{ $name }}[{{ $v }}]"{{ ($checked) ? ' checked' : '' }}>
        {{ $v }}
      </label>
    </div>
    @endforeach
  @endif
@endif

<input type="hidden" name="type" value="checkbox">

<label class="checkbox">
  <input type="checkbox">
  Tout cocher
</label>
