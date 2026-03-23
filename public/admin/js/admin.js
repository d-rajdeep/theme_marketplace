$(document).ready(function () {
    // Sidebar Toggle
    $('#sidebarToggle').click(function () {
        $('.admin-sidebar').toggleClass('active');
    });

    // Close sidebar when clicking outside on mobile
    $(document).click(function (event) {
        if ($(window).width() <= 768) {
            if (!$(event.target).closest('.admin-sidebar').length &&
                !$(event.target).closest('#sidebarToggle').length) {
                $('.admin-sidebar').removeClass('active');
            }
        }
    });

    // Admin Dropdown
    $('#adminDropdown').click(function (e) {
        e.stopPropagation();
        $('#adminDropdownMenu').toggleClass('show');
    });

    // Close dropdown when clicking outside
    $(document).click(function () {
        $('#adminDropdownMenu').removeClass('show');
    });

    // Prevent dropdown from closing when clicking inside
    $('#adminDropdownMenu').click(function (e) {
        e.stopPropagation();
    });

    // Table row hover effect
    $('.data-table tbody tr').hover(
        function () {
            $(this).addClass('table-row-hover');
        },
        function () {
            $(this).removeClass('table-row-hover');
        }
    );

    // Delete confirmation
    $('.delete-btn').click(function (e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});
