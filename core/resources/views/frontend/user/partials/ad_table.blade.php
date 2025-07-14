<style>
    .btn-profile {
    border: none;
    border-radius: 4px;
    color: #fff;
    font-size: 13px;
    padding: 4px 10px;
    cursor: pointer;
    }

    .btn-bg-1 {
        background-color: #007bff;
    }

    .btn-bg-1:hover {
        background-color: #0056b3; 
    }
</style>
@php($isFreelancer = $isFreelancer ?? false)
<table>
    <thead>
    <tr>
        <th>{{ __('Title') }}</th>
        <th>{{ __('Company Name') }}</th>
        <th>{{ __('Type') }}</th>
        <th>{{ __('Quantity') }}</th>
        <th>{{ __('Payable Amount') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Action') }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($ads as $ad)
        <tr>
            <td>{{$ad->title}}</td>
            <td>{{$ad->company}}</td>
            <td>{{$ad->optimize_for}}</td>
            <td>{{$ad->quantity}}</td>
            <td>${{$ad->quantity*$ad->ppq}}</td>
            <td>{{$ad->status}}</td>
            <!-- <td>
                @if(!$ad->is_paid)
                    <form method="post" action="{{$isFreelancer ? route('freelancer.ad.pay') : route('client.ad.pay')}}">
                        @csrf
                        <input type="hidden" value="{{$ad->id}}" name="id">
                        <button class="btn-profile btn-bg-1">Pay Now</button>
                    </form>
                @endif
            </td> -->
            <!-- Action Column -->
            <td style="white-space: nowrap;">
                @if(!$ad->is_paid)
                    <!-- Pay Now -->
                    <form method="post" action="{{ $isFreelancer ? route('freelancer.ad.pay') : route('client.ad.pay') }}" class="d-inline">
                        @csrf
                        <input type="hidden" value="{{ $ad->id }}" name="id">
                        <button class="btn-profile btn-bg-1 btn-sm">Pay Now</button>
                    </form>

                    <!-- Edit -->
                    <button 
                        type="button"
                        class="btn-profile btn-bg-1 btn-sm editAdBtn"
                        data-id="{{ $ad->id }}"
                        data-title="{{ $ad->title }}"
                        data-company="{{ $ad->company }}"
                        data-url="{{ $ad->url }}"
                        data-description="{{ $ad->description }}"
                        data-quantity="{{ $ad->quantity }}"
                        data-optimize_for="{{ $ad->optimize_for }}"
                        data-image="{{ asset('assets/uploads/ads/' . $ad->cover_image) }}"
                        data-bs-toggle="modal"
                        data-bs-target="#editAdModal">
                        Edit
                    </button>

                    <!-- Delete -->
                    <form method="POST" action="{{ route('ad.delete', $ad->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this ad?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn-profile btn-bg-1 btn-sm">Del</button>
                    </form>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">No Ads Found</td>
        </tr>
    @endforelse
    </tbody>
</table>

<!-- Edit Ad Modal -->
<div class="modal fade" id="editAdModal" tabindex="-1" aria-labelledby="editAdModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAdForm" method="POST" action="{{ route('ad.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editAdId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAdModalLabel">Edit Advertisement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Error Display -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- End Error Display -->
                    <div class="mb-3">
                        <label>Company</label>
                        <input type="text" class="form-control" name="company" id="editCompany">
                    </div>
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" id="editTitle">
                    </div>
                    <div class="mb-3">
                        <label>URL</label>
                        <input type="text" class="form-control" name="url" id="editUrl">
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" id="editDescription">
                    </div>
                    <div class="mb-3">
                        <label>Optimize For</label>
                        <select name="optimize_for" id="editOptimizeFor" class="form-control">
                            <option value="click">Click</option>
                            <option value="impression">Impression</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <select name="quantity" id="editQuantity" class="form-control">
                            <option value="1000">1000</option>
                            <option value="2000">2000</option>
                            <option value="3000">3000</option>
                            <option value="4000">4000</option>
                            <option value="5000">5000</option>
                        </select>
                    </div>
                    <!-- File input -->
                    <div class="mb-3">
                        <label>Cover Image (optional)</label>
                        <input type="file" class="form-control" name="cover_image">
                    </div>

                    <!-- Image preview area -->
                    <div class="mb-3" id="currentImageWrapper" style="display: none;">
                        <label>Current Image</label><br>
                        <img id="currentImagePreview" src="" alt="Current Image" style="max-height: 100px; border: 1px solid #ddd; padding: 4px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('script')
<script>
    $(document).ready(function () {
        $('.editAdBtn').on('click', function () {
            $('#editAdId').val($(this).data('id'));
            $('#editTitle').val($(this).data('title'));
            $('#editCompany').val($(this).data('company'));
            $('#editUrl').val($(this).data('url'));
            $('#editDescription').val($(this).data('description'));
            $('#editQuantity').val($(this).data('quantity'));
            $('#editOptimizeFor').val($(this).data('optimize_for'));
        });
    });
</script>
@endsection


