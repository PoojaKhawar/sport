<div class="modal fade add_modal_form" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Add Newsletter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.newsletters.add') }}" method="post" class="insert_modal_form" autocomplete="off" novalidate="novalidate">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="response_message"></div>
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter email" required />
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
        </div>
    </div>
</div>