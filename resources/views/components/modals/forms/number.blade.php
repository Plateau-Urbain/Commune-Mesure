@if(is_object($value))
  @foreach($value as $key => $v)
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label">{{ $key }} : </label>
      </div>
      <div class="field-body">
        <p class="control is-expanded">
          <input class="input" type="number" min=0 name="{{ $name }}[{{ $key }}]" value="{{ $v }}">
        </p>
      </div>
    </div>
  @endforeach
@else
  <input class='input-number' min=0 name="{{ $name }}" type='number' value="{{ $value }}"/>
@endif
<input type="hidden" value="number" name="type">
