<div>
  <input type="radio" id="yes" name="{{ $name }}" value="Yes" {{ $answer === 'Yes' ? 'checked' : '' }}>
  <label for="yes">Oui</label><br>
  <input type="radio" id="no" name="{{ $name }}" value="No" {{ $answer === 'No' ? 'checked' : '' }}>
  <label for="no">Non</label><br>
</div>
