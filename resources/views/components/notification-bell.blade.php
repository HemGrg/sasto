<a id="notification-bell" href="/notifications" class="nav-link notification-link">
<i class="fa-solid fa-bell"></i>
    <span class="badge badge-danger navbar-badge">0</span>
</a>

@push('push_scripts')
    <script>
        function loadUnreadNotificationsCount() {
            $.ajax({
                url: '/notifications/unread-count',
                type: 'GET',
                success: function (data) {
                    if (data.count > 0) {
                        $('#notification-bell span').text(data.count);
                    }
                },
                complete: function () {
                    setTimeout(loadUnreadNotificationsCount, 5000);
                }
            });
        }

        $(document).ready(function () {
            loadUnreadNotificationsCount();
        });
    </script>
@endpush