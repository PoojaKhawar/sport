<div class="text-right mb-2">
	<label id="permissions-error" class="error" for="permissions">@error('permissions') {{ $message }} @enderror</label>

    <span class="badge bg-label-primary cursor_pointer" onclick="$('#permissionTable input[type=checkbox]').prop('checked', true)">
    	<i class="fas fa-check"></i> Select All
    </span>
    <span class="badge bg-label-danger cursor_pointer" onclick="$('#permissionTable input[type=checkbox]').prop('checked', false)">
    	<i class="fas fa-times"></i> Deselect All
    </span>
</div>
<table class="table">
	<thead class="thead-light">
		<tr>
			<th>Modules</th>
			<th>Listing</th>
			<th>Create</th>
			<th>Update</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		@php 
			$adminPermissions = isset($adminPermissions) && $adminPermissions ? $adminPermissions : old('permissions');
		@endphp
		@foreach($permissions as $p)
		@php 
			$permission = json_decode($p['permissions'],true);
		@endphp
		<tr>
			<td>{{ $p['title'] }}</td>
			<td>
				@if($permission['listing'])
				<div class="form-check form-switch mt-2">
            		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="listing" {{ (isset($adminPermissions[$p['id']]) && in_array('listing', $adminPermissions[$p['id']]) ? 'checked' : '') }} />
              	</div>
				@endif
			</td>
			<td>
				@if($permission['create'])
				<div class="form-check form-switch mt-2">
            		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="create" {{ (isset($adminPermissions[$p['id']]) && in_array('create', $adminPermissions[$p['id']]) ? 'checked' : '') }} />
              	</div>
				@endif
			</td>
			<td>
				@if($permission['update'])
				<div class="form-check form-switch mt-2">
            		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="update" {{ (isset($adminPermissions[$p['id']]) && in_array('update', $adminPermissions[$p['id']]) ? 'checked' : '') }} />
              	</div>
				@endif
			</td>
			<td>
				@if($permission['delete'])
				<div class="form-check form-switch mt-2">
            		<input type="checkbox" class="form-check-input" name="permissions[{{ $p['id'] }}][]" value="delete" {{ (isset($adminPermissions[$p['id']]) && in_array('delete', $adminPermissions[$p['id']]) ? 'checked' : '') }} />
              	</div>
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>