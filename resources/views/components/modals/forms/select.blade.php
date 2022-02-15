<div class="select">
  <select name="{{ $name }}">
    @foreach ($value as $k => $v)
      <option{{ ($v === 1) ? ' selected' : '' }}>{{ $k }}</option>
    @endforeach
  </select>
  <input type="hidden" name="type" value="select">
</div>
