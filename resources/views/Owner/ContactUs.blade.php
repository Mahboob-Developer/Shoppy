@extends('Owner.MasterView')

@php
    $sno = 1;
@endphp

@section('location')
<div class="container-fluid table-responsive my-2">
    <table class="table table-striped border">
        <thead>
            <tr>
                <th class="text-center">S.N</th>
                <th class="text-center">Email</th>
                <th class="text-center">Subject</th>
                <th class="text-center">Message</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contactDetail as $contactItem)
                <tr>
                    <td class="text-center">{{ $sno++ }}</td>
                    <td class="text-center">{{ $contactItem->email }}</td>
                    <td class="text-center">{{ $contactItem->subject }}</td>
                    <td class="text-center">{{ $contactItem->problem }}</td>
                    <td class="text-center">
                        <span class="mx-auto d-flex">
                            @if ($contactItem->status=='Reply')
                                
                            <a href="{{ URL::to('/ContactUs/Reply/' . $contactItem->id) }}" class="btnPrimary">Reply</a>
                            @endif
                            @if ($contactItem->status=='Done')
                                
                            <button type="button" class="btnPrimary" disabled>Done</button>
                            @endif
                            
                            <a href="{{ URL::to('/ContactUs/Delete/' . $contactItem->id) }}" class="btnDanger">Delete</a>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Reply Modal -->
<form id="ReplyForm" method="POST" action="{{ URL::to('/ContactReply/' . ($id ?? 0)) }}">
    @csrf
    <div class="modal fade" id="Reply" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a href="{{ URL::to('/ContactUs') }}" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                </div>
                <h3 class="text-center">Contact-Us</h3>
                <div class="modal-body">
                    <div class="form-floating mb-3 py-2">
                        <label for="subject">Enter Subject</label>
                        <input type="text" class="form-control @error('subject')@enderror" id="subject" name="subject" value="{{ old('subject') }}">
                        <!-- Display error message for 'subject' -->
                        @error('subject')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3 py-3">
                        <label for="message">Enter Reply Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                        <!-- Display error message for 'message' -->
                        @error('message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btnPrimary">Submit</button>
                    <a href="{{ URL::to('/ContactUs') }}" class="btn btnDanger">No</a>
                </div>
            </div>
        </div>
    </div>
</form>


<!-- Delete Modal -->
<form id="DeleteForm" method="POST" action="{{ URL::to('/ContactDelete/' . ($id ?? 0)) }}">
    @csrf
    <div class="modal fade" id="Delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to Delete?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btnPrimary">Yes</button>
                    <a href="{{URL::to('/ContactUs')}}" class="btn btnDanger">No</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables for ID and action type (if passed from the server)
        var id = "{{ $id ?? 0 }}";
        var button = "{{ $type ?? '' }}";

        if (id > 0) {
            if (button === 'Reply') {
                var replyModal = new bootstrap.Modal(document.getElementById('Reply'));
                replyModal.show(); // Show the Reply modal
            }

            if (button === 'Delete') {
                var deleteModal = new bootstrap.Modal(document.getElementById('Delete'));
                deleteModal.show(); // Show the Delete modal
            }
        }
    });
</script>
