@foreach($listing->items() as $k => $row)
<tr>
	<td>
		<!-- MAKE SURE THIS HAS ID CORRECT AND VALUES CORRENCT. THIS WILL EFFECT ON BULK CRUTIAL ACTIONS -->
		<div class="form-check" style="opacity: 0;">
        	<input type="checkbox" class="form-check-input listing_check" value="{{ $row->id }}" id="listing_check{{ $row->id }}">
        	<label class="form-check-label" for="listing_check{{ $row->id }}"></label>
      	</div>
	</td>
	<td>
		{{ $row->id }}
	</td>
	<td>
		{{ $row->title }}
	</td>
	{{-- <td>
		<span class="badge bg-blue-grey fz-12">{{ $row->owner_first_name . ' ' . $row->owner_last_name }}</span>
	</td> --}}
	{{-- <td>
		<div class="form-check form-switch mt-2">
			@php 
				$switchUrl =  route('admin.actions.switchUpdate', ['relation' => 'email_templates', 'field' => 'status', 'id' => $row->id])
			@endphp
    		<input type="checkbox" name="status" class="form-check-input" value="1" onchange="switch_action('{{ $switchUrl }}', this)" {{ ($row->status ? 'checked' : '') }}/>
      	</div>
	</td> --}}
	<td>
		{{ _dt($row->created_at) }}
	</td>
	<td class="text-right">
		<div class="action_dropdown btn-group">
			<a href="javascript:;" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-ellipsis-v"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-end">
				@if(Permission::hasPermission('email_templates', 'update'))
				<li>
					<a class="dropdown-item" href="{{ route('admin.emailTemplates.edit', ['id' => $row->id]) }}">
						<i class="fas fa-edit text-primary"></i>
						<span class="status">Edit</span>
					</a>
				</li>
				@endif

				{{-- <li>
					<a class="dropdown-item" href="{{ route('admin.emailTemplates.view', ['id' => $row->id]) }}">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a>
				</li> --}}

				{{-- @if(Permission::hasPermission('email_templates', 'delete'))
				<li>
					<a class="dropdown-item delete_confirm" href="{{ route('admin.emailTemplates.delete', ['id' => $row->id]) }}">
						<i class="fas fa-trash-alt text-danger"></i>
						<span class="status">Delete</span>
					</a>
				</li>
				@endif --}}
			</ul>
		</div>
	</td>
</tr>
@endforeach