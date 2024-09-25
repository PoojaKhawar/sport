@foreach($listing->items() as $k => $row)
<tr>
	<td>
		<!-- MAKE SURE THIS HAS ID CORRECT AND VALUES CORRENCT. THIS WILL EFFECT ON BULK CRUTIAL ACTIONS -->
		<div class="form-check">
        	<input type="checkbox" class="form-check-input listing_check" value="{{ $row->id }}" id="listing_check{{ $row->id }}">
        	<label class="form-check-label" for="listing_check{{ $row->id }}"></label>
      	</div>
	</td>
	<td>
		{{ $row->id }}
	</td>
	<td>
		{{ $row->email }}
	</td>
	{{-- <td>
		{{ $row->owner_first_name . ' ' . $row->owner_last_name }}
	</td> --}}
	<td>
		<div class="form-check form-switch mt-2">
			@php 
				$switchUrl =  route('admin.actions.switchUpdate', ['relation' => 'newsletters', 'field' => 'status', 'id' => $row->id])
			@endphp
    		<input type="checkbox" name="status" class="form-check-input" value="1" onchange="switch_action('{{ $switchUrl }}', this)" {{ ($row->status ? 'checked' : '') }}/>
      	</div>
	</td>
	<td>
		{{ _dt($row->created_at) }}
	</td>
	<td class="text-right">
		<div class="action_dropdown btn-group">
			<a href="javascript:;" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				@if(Permission::hasPermission('newsletters', 'update'))
				<li>
					{{-- <a class="dropdown-item" href="{{ route('admin.newsletters.edit', ['id' => $row->id]) }}">
						<i class="fas fa-edit text-primary"></i>
						<span class="status">Edit</span>
					</a> --}}
					<a class="dropdown-item get_edit_modal" href="javascript:;" data-id="{{ $row->id }}" data-url="{{ route('admin.newsletters.get', ['id' => $row->id]) }}" data-bs-toggle="" data-bs-target=".edit_modal_form">
						<i class="fas fa-edit text-primary"></i>
						<span class="status">Edit</span>
					</a>
				</li>
				@endif

				<li>
					{{-- <a class="dropdown-item" href="{{ route('admin.newsletters.view', ['id' => $row->id]) }}">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a> --}}

					<a href="javascript:;" class="dropdown-item get_view_modal" data-id="{{ $row->id }}" data-url="{{ route('admin.newsletters.view', ['id' => $row->id]) }}" data-bs-toggle="" data-bs-target=".view_modal_page">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a>
				</li>

				@if(Permission::hasPermission('newsletters', 'delete'))
				<li>
					<a class="dropdown-item delete_confirm" href="{{ route('admin.newsletters.delete', ['id' => $row->id]) }}">
						<i class="fas fa-trash-alt text-danger"></i>
						<span class="status">Delete</span>
					</a>
				</li>
				@endif
			</ul>
		</div>
	</td>
</tr>
@endforeach