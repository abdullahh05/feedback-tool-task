<script>
    var authElements = document.getElementsByClassName('auth');

    for (var i = 0; i < authElements.length; i++) {
        authElements[i].addEventListener('click', function() {
            var isLoggedIn = {!! auth()->check() ? 'true' : 'false' !!};

            if (!isLoggedIn) {
                window.location.href = '{{ route("login") }}';
            }
        });
    }
</script>
