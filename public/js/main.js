$(document).on('click', '#close-preview', function () {
    $('.scanning-file').popover('hide');
    // Hover befor close the preview
    $('.scanning-file').hover(
        function () {
            $('.scanning-file').popover('show');
        },
        function () {
            $('.scanning-file').popover('hide');
        }
    );
});

$(function () {
    // Create the close button
    var closebtn = $('<button/>', {
        type: "button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;'
    });
    closebtn.attr("class", "close pull-right");
    // Clear event
    $('.scanning-file-clear').click(function () {
        $('.scanning-file').attr("data-content", "").popover('hide');
        $('.scanning-file-filename').val("");
        $('.scanning-file-clear').hide();
        $('.scanning-file-input input:file').val("");
        $(".scanning-file-input-title").text("Browse");
    });
    // Create the preview image
    $(".scanning-file-input input:file").change(function () {
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".scanning-file-input-title").text("Change");
            $(".scanning-file-clear").show();
            $(".scanning-file-filename").val(file.name);
        };
        reader.readAsDataURL(file);
    });
});