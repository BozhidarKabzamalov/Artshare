@if($errors->has($field))
    <p class='error-message'>{{ $errors->first($field) }}</p>
@endif
