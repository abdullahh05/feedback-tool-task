@extends('layouts.app')
@section('content')

    <div class="container p-5">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success">
                    <pre>{{session('success')}}</pre>
                </div>
            @endif
            <div class="col-md-3 offset-md-5">
                <h2 style="color: #6d6d6d">FEEDBACKS</h2>
            </div>
            <div class="col-md-2 offset-md-2">
                <button class="btn btn-sm btn-primary auth"  data-bs-toggle="modal" data-bs-target="#createFeedback">Add Feedback</button>
            </div>
            <div class="col-md-12">
                @foreach($feedback as $item)
                    <div class="card bg-light m-3" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 my-2 ms-3">
                                    <h5>{{$item->title}}</h5>
                                </div>
                                <div class="col-md-3">
                                    <pre class="m-0"><b>Category:</b> {{$item->category->name}}</pre>
                                    <pre><b>Submit by:</b> {{$item->owner->name}}</pre>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10  my-1 ms-3">
                                    <p>{!! $item->description !!}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-secondary ms-3" onclick="showComments({{$item->id}})">Show comments</button>
                                    <button class="btn btn-sm btn-info offset-md-8 auth" onclick="addComment({{$item->id}})">Add Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    {{$feedback->links("pagination::bootstrap-5")}}
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="createFeedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Feedback</h5>
                    <button type="button" class="close btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="feedbackForm" action="{{url("feedback/store")}}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <label class="mt-2">Title :</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter title" required>
                        <label class="mt-2" for="feedback_desc">Description :</label> <br>
                        <textarea name="description" rows="4" cols="55" placeholder="Enter description" id="feedback_desc" ></textarea><br>
                        <label class="mt-2">Select category :</label>
                        <select class="form-control" name="category" required>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-sm btn-primary" type = "submit" id="add_feedback">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Comment Modal -->
    <div class="modal fade" id="createComment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Comment</h5>
                    <button type="button" class="close btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="commentForm">
                    <div class="modal-body">
                        <div id="commentErrors" class="alert alert-success" hidden></div>
                        @csrf
                        <label class="mt-2">Comment :</label>
                        <input type="text" class="form-control" name="comment" placeholder="comment here.." id="writeComment">
                        <i style="font-size: 10px">type '@' to mention a user</i>
                        <div class="userDropdown">
                            <select name="user_mention" class="form-control" id="userDropdown"></select>
                        </div>
                        <input type="hidden" class="form-control" name="feedback_id" id="commentFeedback" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-sm btn-primary" type = "submit" id="addCommentBtn">Add comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show Comment Modal -->
    <div class="modal fade show_comments" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container-fluid">
                    <div class="row m-3">
                        <div class="col">
                            <h5>Comments list :</h5>
                        </div>
                    </div>
                    <div id="showNewComments">
                        <p>No comments added.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function addComment(feedbackID)
        {
            $("#commentFeedback").val(feedbackID);
            $("#createComment").modal('show');
        }
        function showComments(feedbackId) {
            $.ajax({
                url: '/comments/' + feedbackId,
                type: 'GET',
                success: function (data) {
                    $("#showNewComments").html('');
                    if(data.status){
                        $(".show_comments").modal('show');
                        if (data.comments.length <= 0) {
                            $("#showNewComments").append('<p>No comment added.</p>');
                        }
                        data.comments.forEach(function (comment) {
                            $("#showNewComments").append('\
                            <div class="row m-3 p-2 rounded" style="border: 1px solid rgba(169, 169, 169, 0.2); box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">\
                                <div class="col-md-12">\
                                    <h6><b>' + comment.comment + '</b></h6>\
                                    <p class="mt-2 mb-0" style="font-size: 12px"><b>Commented by:</b> ' + comment.created_by + '    -    (' + comment.created_at + ')</p>\
                                </div>\
                            </div>');
                        });
                    }else{
                        $("#showNewComments").append('<p>No comment added.</p>');
                    }
                },
                error: function (error) {
                    console.error('Error fetching comments:', error);
                }
            });
        }
    </script>

@endsection

