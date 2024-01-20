ClassicEditor
    .create( document.querySelector( '#feedback_desc' ) )
    .catch( error => {
        console.error( error );
    } );

$(document).ready(function () {

    // user mention in a comment
    $('#writeComment').on('input', function() {
        var commentText = $(this).val();
        var lastChar = commentText.slice(-1);
        $('.userDropdown').hide();

        if (lastChar === '@') {
            $.ajax({
                url: '/users-list',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    displayUserListDropdown(data.users);
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        }
    });
    function displayUserListDropdown(users) {
        $('#userDropdown').empty();
        users.forEach(function(user) {
            $('#userDropdown').append('<option value="' + user.name + ' ">' + user.name + '</option>');
        });
        $('#userDropdown').attr('size', users.length);
        // Show the dropdown
        $('.userDropdown').show();
    }
    $('.userDropdown').hide();

    $("#userDropdown").on("change",function (){
        let user = $(this).val();
        let mention = $("#writeComment").val()+user;
        $("#writeComment").val(mention);
        $('.userDropdown').hide();
    });

    // adding comment in a feedback
    $("#addCommentBtn").on("click", function (e){
        e.preventDefault();
        $(this).html('Adding..');
        $.ajax({
            data: $('#commentForm').serialize(),
            url: "/comment-store",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#commentForm').trigger("reset");
                $('#addCommentBtn').html('Add comment');
                $('#commentErrors').removeAttr("hidden");
                $('#commentErrors').html(data.success);

                // Delay for 2 seconds before hiding the modal
                setTimeout(function() {
                    $("#createComment").modal('hide');
                    setTimeout(function() {
                        $('#commentErrors').attr("hidden", true);
                    }, 800);
                }, 1000);

            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Save Changes');
            }
        });
    });

});


