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
		{{ $row->parent_title ? $row->parent_title : $row->title }}
	</td>
	
	<!-- In case of subcategory enable start -->
	@if(Setting::get('sub_category_enable'))
	<td>
		{{ !$row->parent_title ? "" : $row->title }}
	</td>
	@endif
	<!-- In case of subcategory enable end -->

	<td>
		{{ $row->owner_first_name . ' ' . $row->owner_last_name }}
	</td>
	<td>
		<div class="form-check form-switch mt-2">
			@php 
				$switchUrl =  route('admin.actions.switchUpdate', ['relation' => 'blog_categories', 'field' => 'status', 'id' => $row->id])
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
				@if(Permission::hasPermission('blog_categories', 'update'))
				<li>
					<a class="dropdown-item" href="{{ route('admin.blogs.categories.edit', ['id' => $row->id]) }}">
						<i class="fas fa-edit text-primary"></i>
						<span class="status">Edit</span>
					</a>
				</li>
				@endif
				
				<li>
					<a class="dropdown-item" href="{{ route('admin.blogs.categories.view', ['id' => $row->id]) }}">
						<i class="fas fa-eye text-info"></i>
						<span class="status">View</span>
					</a>
				</li>

				@if(Permission::hasPermission('blog_categories', 'delete'))
				<li>
					<a class="dropdown-item delete_confirm" href="{{ route('admin.blogs.categories.delete', ['id' => $row->id]) }}">
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