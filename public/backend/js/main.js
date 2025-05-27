$(document).ready(function () {
    // Toggle Sidebar
    $("#toggleSidebar").on("click", function () {
        $("#sidebar").toggleClass("collapsed-sidebar");
        $("#content").toggleClass("collapsed-content");
    });

    // Switch active class when clicking on menu items
    $(".menu_item > a").on("click", function (event) {
        // event.preventDefault(); // Prevents page refresh
        // Close all other dropdowns when clicking on a menu item
        $(".dropdwn-mnu").not($(this).next()).addClass("collapsed");
        $(".dropdwn_toggler").not(this).removeClass("active");
    });

    // Toggle dropdown and collapse others
    $(".dropdwn_toggler").on("click", function (event) {
        event.preventDefault(); // Prevent default link behavior

        let dropdownMenu = $(this).next(".dropdwn-mnu");

        // Close all dropdowns except the clicked one
        $(".dropdwn-mnu").not(dropdownMenu).addClass("collapsed");
        $(".dropdwn_toggler").not(this).removeClass("active");

        // Toggle the clicked dropdown
        dropdownMenu.toggleClass("collapsed");
        $(this).toggleClass("active");
    });

    // Profile Dropdown Toggle
    $(".profile-toggle").on("click", function (event) {
        event.stopPropagation(); // Prevent clicking outside immediately closing it
        $(this).toggleClass("active");
        $(".profile-dropdown").toggleClass("show");
    });

    // Close profile dropdown when clicking outside
    $(document).on("click", function (event) {
        if (
            !$(".profile-toggle").is(event.target) &&
            !$(".profile-dropdown").has(event.target).length
        ) {
            $(".profile-toggle").removeClass("active");
            $(".profile-dropdown").removeClass("show");
        }
    });
});
