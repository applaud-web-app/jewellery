// ---------------------- gallery for documnets-----------------//

$(document).ready(function() {
    lightGallery(document.getElementById('document-gallery'), {
        speed: 500,
        selector: '.item',
        thumbnail: true,
        plugins: [lgZoom, lgFullscreen],
    });

});



// ------------------- listwrapper menu --------------- //

$(document).ready(function() {



    $('#goPrev').click(function() {
        $('.listwrapper').animate({ scrollLeft: '-=100' }, 200);
    });

    $('#goNext').click(function() {
        $('.listwrapper').animate({ scrollLeft: '+=100' }, 200);
    });

    check_navigation_tabs();



    function check_navigation_tabs() {
        var container_width = $(".listwrapper").width();
        var tabs_width = 0;

        $('.menu-listbtn li').each(function() {
            tabs_width += $(this).outerWidth();
        });


        if (tabs_width > container_width) {
            if (container_width > 768) {
                $("#goPrev").show();
                $("#goNext").show();
                $(".menu-listbtn li:first-child").css({ 'margin-left': '30px' })
                $(".menu-listbtn li:last-child").css({ 'margin-right': '30px' })

            }

        }

    }



});


// ------------------------tiny mce editor ------------------- ///

tinymce.init({
    selector: '.my_tinyeditor',
    plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor  insertdatetime advlist lists wordcount  textpattern noneditable help charmap quickbars emoticons',
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough |  fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',

    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_retention: '2m',
    image_advtab: true,
    themes: "silver",

    importcss_append: false,
    branding: false,

});

// ================= pie chart storage ================ //
var screenWidth = $(window).width();

if ($('#storage_chart').length > 0) {

    //pie chart
    const pie_chart = document.getElementById("storage_chart").getContext('2d');
    // pie_chart.height = 100;
    new Chart(pie_chart, {
        type: 'pie',

        data: {
            datasets: [{
                data: [133.3, 86.2],
                backgroundColor: [
                    "#FF6384",
                    "#63FF84",
                ]
            }],
            labels: [
                "Available Space",
                "Used Space",
            ],
        },
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
            },

            maintainAspectRatio: false,

        }
    });
}



// ------------------ choose file option ---------------//

function prevImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).parents('.form-group').prev('.upimage').attr('src', e.target.result);

        }
        reader.readAsDataURL(input.files[0]);
    } else {
        alert('select a file to see preview');
        $('.upimage').attr('src', '');
    }
}


$(document).ready(function() {



    $('.my_datepicker').datepicker({
        changeMonth: true,
        changeYear: true,
    });


        // ----------password toggle------------//

    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


});