<div class="select">
  <select name="{{ $name }}">
    @foreach ($value as $k => $v)
      {{ $k }} {{ $v }}
      <option{{ ($v === 1) ? ' selected' : '' }}>{{ $k }}</option>
    @endforeach
  </select>
</div>
