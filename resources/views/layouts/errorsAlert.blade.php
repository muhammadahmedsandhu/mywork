<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if (Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }} d-flex justify-content-between align-items-center">
                {{ Session::get('alert-' . $msg) }} <a class="close h5" data-dismiss="alert" aria-label="close"
                    style="cursor: pointer;">&times;</a>
            </p>
        @endif
    @endforeach
</div>

<script>
    let closeButtons = document.querySelectorAll('.close');
    closeButtons.forEach(function(closeButton) {
        closeButton.addEventListener('click', function(event) {
            event.target.parentElement.remove();
        });
    });
</script>
