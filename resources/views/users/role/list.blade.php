@extends('layouts.vertical', ['title' => 'Roles List'])

@section('content')

    <div class="card overflow-hiddenCoupons">
        <div class="card-body p-0">
            <div class="table-responsive">
                <form method="GET" action="roles" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control w-1/3"
                            placeholder="Search users by name, email, or role..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
                <table class="table align-middle mb-0 table-hover table-centered">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>User</th>
                            <th>Tags</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="">
                                        <div class="">
                                            <span class=" bg-primary-subtle text-primary  fw-bold shadow">

                                                {{$user->name}}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-light-subtle text-muted border py-1 px-2">{{ $user->roles->first()?->name ?? 'N/A' }}</span>
                                </td>
                                <td>

                                    {{ $user->roles->pluck('name')->join(', ') ?: 'No Role Assigned' }}
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" checked>
                                    </div>
                                </td>
                                <td>
                                    {{-- <div class="d-flex gap-2">
                                        <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken"
                                                class="align-middle fs-18"></iconify-icon></a> --}}
                                        {{-- <a href="#" class="btn btn-soft-primary btn-sm"><iconify-icon
                                                icon="solar:pen-2-broken" data-bs-toggle="modal"
                                                data-bs-target="#addFinancialsModal"
                                                class="align-middle fs-18"></iconify-icon></a> --}}
                                        {{-- <a href="#" class="btn btn-soft-primary btn-sm"
                                            @click.prevent="$dispatch('close-all-modals'); userId = {{ $user->id }}">
                                            <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                        </a> --}}
                                        <a href="#" class="btn btn-soft-primary btn-sm"
                                            wire:click.prevent="setUserId({{ $user->id }})" data-bs-toggle="modal"
                                            data-bs-target="#addFinancialsModal">
                                            <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                        </a>
                                        <a href="{{ route('delete.user', $user->id) }}"
                                            class="btn btn-soft-danger btn-sm"><iconify-icon
                                                icon="solar:trash-bin-minimalistic-2-broken"
                                                class="align-middle fs-18"></iconify-icon></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
                <div class="card-footer border-top">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                Showing <span class="fw-semibold">{{ $users->firstItem() }}</span> to
                                <span class="fw-semibold">{{ $users->lastItem() }}</span> of
                                <span class="fw-semibold">{{ $users->total() }}</span> entries
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination pagination-separated pagination-sm mb-0">
                                    {{ $users->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- end table-responsive -->
        </div>
        <!-- Alpine wrapper to manage modal state -->
        <div x-data="{ userId: null }" x-init="$watch('userId', value => {
                if (value !== null) {
                    const modal = new bootstrap.Modal($refs.roleModal);
                    modal.show();
                }
            })">
            <!-- Modal -->
            {{-- <div class="modal fade" x-ref="roleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                    <div class="modal-content rounded-1 border-0">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Change the role of user</h6>
                            <button type="button" class="btn-close border-0 shadow-none" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <template x-if="userId">
                                <livewire:user-roles :userId="`${userId}`" :key="`${userId}`" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="modal fade" id="addFinancialsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
                <div class="modal-content rounded-1 border-0">
                    <div class="modal-header">
                        <h6 class="modal-title text-muted">Change the role of user</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @livewire('user-roles', ['userId' => $user->id])
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end card -->

@endsection