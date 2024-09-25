<form action="{{ route('admin.newsletters.edit', ['id' => $row->id]) }}" method="post" class="update_modal_form " autocomplete="off" novalidate="novalidate">
    <!--!! CSRF FIELD !!-->
    {{ csrf_field() }}
    <div class="modal-body">
        <div class="response_message"></div>
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ old('email', $row->email) }}" placeholder="Enter email" required />
                    <label id="email-error" class="error" for="email">@error('email') {{ $message }} @enderror</label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer d-block clearfix">
        <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary float-end">Save changes</button>
    </div>
</form>