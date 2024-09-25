<div class="modal fade" id="export" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Export Records</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.export') }}" id="exportRecords">
                <div class="modal-body">
                    <p>Maximum of 3000 records can be export from all records at one time.</p>
                    <input type="hidden" class="filter-query" value="">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group mt-2 mb-0">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="type" id="allRecords" value="all" checked="checked" />
									<label class="form-check-label" for="allRecords">All Records</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="type" id="filtered" value="filtered"/>
									<label class="form-check-label" for="filtered">Filtered Records</label>
								</div>
							</div>
							<div class="form-group mt-3" id="daterangeFilter">
								<label class="form-label">Apply Date Range</label>
								<input type="text" name="daterange" class="form-control" id="datarangepicker" value="" placeholder="MM/DD/YYYY - MM/DD/YYYY">
							</div>
							<div class="form-group mt-3 d-none" id="filteredMessage">
								<h3>
                                    <mark>
                                        <i class="fas fa-exclamation-circle"></i> Background applied filters will be applicable.
                                    </mark>
                                </h3>
							</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-block clearfix">
                    <button type="button" class="btn btn-danger float-start" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary float-end" id="export_excel"><i class="fas fa-file-export"></i> Export</button>
                </div>
            </form>
        </div>
    </div>
</div>