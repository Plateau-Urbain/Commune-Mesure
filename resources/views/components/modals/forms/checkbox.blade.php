@foreach($value as $v => $checked)
<div class="field is-horizontal">
  <label class="checkbox">
    <input type="checkbox" name="{{ $name }}[{{ $v }}]"{{ ($checked) ? ' checked' : '' }}>
    {{ $v }}
  </label>
</div>
@endforeach

<input type="hidden" name="type" value="checkbox">

<label class="checkbox">
  <input type="checkbox">
  Tout cocher
</label>
