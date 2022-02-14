@foreach($value as $v => $checked)
<div class="field is-horizontal">
  <label class="checkbox">
    <input type="checkbox" name="{{ $name }}[{{ $v }}]"{{ ($checked) ? ' checked' : '' }}>
    {{ $v }}
  </label>
</div>
@endforeach

<label class="checkbox">
  <input type="checkbox">
  Tout cocher
</label>
