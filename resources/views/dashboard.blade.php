<style>
    /* Tailwind-based Pagination Styling */
.pagination {
    @apply flex items-center gap-2;
}

.pagination .page-item {
    @apply inline-flex;
}

.pagination .page-link {
    @apply px-3 py-1 rounded-md text-sm font-medium transition-colors;
}

.pagination .page-item.active .page-link {
    @apply bg-blue-600 text-white;
}

.pagination .page-item:not(.active) .page-link {
    @apply text-gray-700 hover:bg-gray-100;
}

.pagination .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed;
}
</style>

@extends('layouts.vertical', ['title' => 'Dashboard'])

@section('content')
    <div class="row">
        <div class="col-xxl-5">
            <div class="row">


                <div class="col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-soft-primary rounded">
                                        <iconify-icon icon="solar:cart-5-bold-duotone"
                                            class="avatar-title fs-32 text-primary"></iconify-icon>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Total News</p>
                                    <h3 class="text-dark mt-1 mb-0">{{$news->count()}}</h3>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div> <!-- end card body -->
                        <div class="card-footer py-2 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-success"> <i class="bx bxs-up-arrow fs-12"></i> 2.3%</span>
                                    <span class="text-muted ms-1 fs-12">Last Week</span>
                                </div>
                                <a href="#!" class="text-reset fw-semibold fs-12">View More</a>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
                <div class="col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-soft-primary rounded">
                                        <i class="bx bx-award avatar-title fs-24 text-primary"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-6 text-start">
                                    <p class="text-muted mb-0 text-truncate">Total Bookmarks</p>
                                    <h3 class="text-dark mt-1 mb-0">{{$totalBookmarks}}</h3>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div> <!-- end card body -->
                        <div class="card-footer py-2 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-success"> <i class="bx bxs-up-arrow fs-12"></i> 8.1%</span>
                                    <span class="text-muted ms-1 fs-12">Last Month</span>
                                </div>
                                <a href="#!" class="text-reset fw-semibold fs-12">View More</a>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
                <div class="col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-soft-primary rounded">
                                        <i class="bx bxs-backpack avatar-title fs-24 text-primary"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Deals</p>
                                    <h3 class="text-dark mt-1 mb-0">976</h3>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div> <!-- end card body -->
                        <div class="card-footer py-2 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-danger"> <i class="bx bxs-down-arrow fs-12"></i> 0.3%</span>
                                    <span class="text-muted ms-1 fs-12">Last Month</span>
                                </div>
                                <a href="#!" class="text-reset fw-semibold fs-12">View More</a>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
                <div class="col-md-6">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-md bg-soft-primary rounded">
                                        <i class="bx bx-dollar-circle avatar-title text-primary fs-24"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0 text-truncate">Booked Revenue</p>
                                    <h3 class="text-dark mt-1 mb-0">$123.6k</h3>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div> <!-- end card body -->
                        <div class="card-footer py-2 bg-light bg-opacity-50">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-danger"> <i class="bx bxs-down-arrow fs-12"></i> 10.6%</span>
                                    <span class="text-muted ms-1 fs-12">Last Month</span>
                                </div>
                                <a href="#!" class="text-reset fw-semibold fs-12">View More</a>
                            </div>
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end col -->

        <div class="col-xxl-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Performance</h4>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-light">ALL</button>
                            <button type="button" class="btn btn-sm btn-outline-light">1M</button>
                            <button type="button" class="btn btn-sm btn-outline-light">6M</button>
                            <button type="button" class="btn btn-sm btn-outline-light active">1Y</button>
                        </div>
                    </div> <!-- end card-title-->

                    <div dir="ltr">
                        <div id="dash-performance-chart" class="apex-charts"></div>
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Conversions</h5>
                    <div id="conversions" class="apex-charts mb-2 mt-n2"></div>
                    <div class="row text-center">
                        <div class="col-6">
                            <p class="text-muted mb-2">This Week</p>
                            <h3 class="text-dark mb-3">23.5k</h3>
                        </div> <!-- end col -->
                        <div class="col-6">
                            <p class="text-muted mb-2">Last Week</p>
                            <h3 class="text-dark mb-3">41.05k</h3>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                    <div class="text-center">
                        <button type="button" class="btn btn-light shadow-none w-100">View Details</button>
                    </div> <!-- end row -->
                </div>
            </div>
        </div> <!-- end left chart card -->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sessions by Country</h5>
                    <div id="world-map-markers" style="height: 316px">
                    </div>
                    <div class="row text-center">
                        <div class="col-6">
                            <p class="text-muted mb-2">This Week</p>
                            <h3 class="text-dark mb-3">23.5k</h3>
                        </div> <!-- end col -->
                        <div class="col-6">
                            <p class="text-muted mb-2">Last Week</p>
                            <h3 class="text-dark mb-3">41.05k</h3>
                        </div> <!-- end col -->
                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-->
        </div> <!-- end col -->

        <div class="col-lg-4">
            <div class="card card-height-100">
                <div class="card-header d-flex align-items-center justify-content-between gap-2">
                    <h4 class="card-title flex-grow-1">Most Bookmarked News</h4>

                    <a href="#" class="btn btn-sm btn-soft-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-nowrap table-centered m-0">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th class="text-muted ps-3">Title</th>
                                <th class="text-muted">Bookmarks</th>
                                {{-- <th class="text-muted">Exit Rate</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mostBookmarkedNews as $news)
                                <tr>
                                    <td class="ps-3"><a href="#" class="text-muted">{{$news['title']}}</a></td>
                                    <td>{{$news['bookmarks']}}</td>
                                    {{-- <td><span class="badge badge-soft-success">4.4%</span></td> --}}
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-4 d-none">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Recent Transactions</h4>
                    <div>
                        <a href="#!" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus me-1"></i>Add
                        </a>
                    </div>
                </div> <!-- end card-header-->
                <div class="card-body p-0">
                    <div class="px-3" data-simplebar style="max-height: 398px;">
                        <table class="table table-hover mb-0 table-centered">
                            <tbody>
                                <tr>
                                    <td>24 April, 2024</td>
                                    <td>$120.55</td>
                                    <td><span class="badge bg-success">Cr</span></td>
                                    <td>Commisions</td>
                                </tr>
                                <tr>
                                    <td>24 April, 2024</td>
                                    <td>$9.68</td>
                                    <td><span class="badge bg-success">Cr</span></td>
                                    <td>Affiliates</td>
                                </tr>
                                <tr>
                                    <td>20 April, 2024</td>
                                    <td>$105.22</td>
                                    <td><span class="badge bg-danger">Dr</span></td>
                                    <td>Grocery</td>
                                </tr>
                                <tr>
                                    <td>18 April, 2024</td>
                                    <td>$80.59</td>
                                    <td><span class="badge bg-success">Cr</span></td>
                                    <td>Refunds</td>
                                </tr>
                                <tr>
                                    <td>18 April, 2024</td>
                                    <td>$750.95</td>
                                    <td><span class="badge bg-danger">Dr</span></td>
                                    <td>Bill Payments</td>
                                </tr>
                                <tr>
                                    <td>17 April, 2024</td>
                                    <td>$455.62</td>
                                    <td><span class="badge bg-danger">Dr</span></td>
                                    <td>Electricity</td>
                                </tr>
                                <tr>
                                    <td>17 April, 2024</td>
                                    <td>$102.77</td>
                                    <td><span class="badge bg-success">Cr</span></td>
                                    <td>Interest</td>
                                </tr>
                                <tr>
                                    <td>16 April, 2024</td>
                                    <td>$79.49</td>
                                    <td><span class="badge bg-success">Cr</span></td>
                                    <td>Refunds</td>
                                </tr>
                                <tr>
                                    <td>05 April, 2024</td>
                                    <td>$980.00</td>
                                    <td><span class="badge bg-danger">Dr</span></td>
                                    <td>Shopping</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div> <!-- end row -->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">
                            Recent News
                        </h4>

                        <a href="{{ route('write.news') }}" class="btn btn-sm btn-soft-primary">
                            <i class="bx bx-plus me-1"></i>Create News
                        </a>
                    </div>
                </div>
                <!-- end card body -->
                <div class="table-responsive table-centered">
                    <table class="table mb-0">
                        <thead class="bg-light bg-opacity-50">
                            <tr>
                                <th class="ps-3">Title</th>
                                <th>Type</th>
                                <th>County</th>
                                <th>Constituency</th>
                                <th>Ward</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsData as $dataNews)
                                <tr>
                                    <td class="ps-3">
                                        {{$dataNews->title}} <!-- Access title properly -->
                                    </td>
                                    <td>
                                        {{$dataNews->type ?? 'N/A'}} <!-- Check if type exists -->
                                    </td>
                                    <td>
                                        <!-- Check if county exists, then access its name -->
                                        {{$dataNews->county ? $dataNews->county->name : 'N/A'}}
                                    </td>
                                    <td>
                                        <!-- Check if region exists, then access its name -->
                                        {{$dataNews->region ? $dataNews->region->name : 'N/A'}}
                                    </td>
                                    <td>
                                        <!-- Check if subcounty exists, then access its name -->
                                        {{$dataNews->subcounty ? $dataNews->subcounty->name : 'N/A'}}
                                    </td>
                                    <td>
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addFinancialsModal-{{ $dataNews->id }}">
                                            Add Financials
                                        </button>
                                        <a href="{{ route('edit.news', $dataNews->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <a href="{{ route('delete.news', $dataNews->id) }}"
                                            class="btn btn-sm btn-primary">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                <!-- table responsive -->

                <div class="card-footer border-top">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                Showing <span class="fw-semibold">{{ $newsData->firstItem() }}</span> to
                                <span class="fw-semibold">{{ $newsData->lastItem() }}</span> of
                                <span class="fw-semibold">{{ $newsData->total() }}</span> entries
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination pagination-separated pagination-sm mb-0">
                                    {{ $newsData->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>


    <!-- Modal -->
    <!-- Modals should be outside the table -->
    @foreach ($newsData as $dataNews)
        <div class="modal fade" id="addFinancialsModal-{{ $dataNews->id }}" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                <div class="modal-content rounded-1 border-0">

                    <div class="modal-header">
                        <h6 class="modal-title text-muted">Add Financials for "{{ $dataNews->title }}"</h6>
                        <button type="button" class="btn-close border-0 shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        @livewire('financials.finance', ['newsItem' => $dataNews], key($dataNews->id))
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    @vite(['resources/js/pages/dashboard.js'])
@endsection