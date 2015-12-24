@foreach($roles as $role)
<option id="role-{{ $role->id }}" value="{{ $role->id }}" @if($user->roles[0]->id == $role->id) selected @endif>{{ $role->name }}</option>
@endforeach