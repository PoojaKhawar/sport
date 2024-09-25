@foreach($states as $c)
<option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
@endforeach