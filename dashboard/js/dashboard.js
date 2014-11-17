$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
        
        $('#side-menu a[href="#create"]').on("click", createManga);
        $('#side-menu a[href="#remove"]').on("click", removeManga);
        $('#side-menu a[href="#edit"]').on("click", editManga);
    });
});

function createManga(event) {
    $("#manga-list").addClass("hidden");
    $("#create-manga").removeClass("hidden");
    $("#edit-manga").addClass("hidden");
    event.preventDefault();
}

function removeManga(event) {
    alert("menu remove");
    //$("#manga-list").addClass("hidden");
    event.preventDefault();
}

function editManga(event) {
    $("#manga-list").addClass("hidden");
    $("#create-manga").addClass("hidden");
    $("#edit-manga").removeClass("hidden");
    event.preventDefault();
}
