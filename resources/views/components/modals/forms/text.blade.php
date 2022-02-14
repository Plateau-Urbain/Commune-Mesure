@if(is_array($value))
  @foreach($value as $v)
    <input class="input" type="text" name="{{ $name }}[]" value="{{ $v }}">
  @endforeach
  <input class="input" type="text" name="{{ $name }}[]">
  <input class="input" type="text" name="{{ $name }}[]">
@else
  <textarea name="{{ $name }}" class="textarea">{{ $value }}</textarea>
@endif
