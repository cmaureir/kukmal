$(function() {

            $("#slideshow > div:gt(0)").hide();

            setInterval(function() {
              $('#slideshow > div:first')
                .fadeOut(1000)
                .next()
                .fadeIn(1000)
                .end()
                .appendTo('#slideshow');
            },  7000);

        });

$(function() {

            $("#slideshowsingle > div:gt(0)").hide();

            setInterval(function() {
              $('#slideshowsingle > div:first')
                .fadeOut(1000)
                .next()
                .fadeIn(1000)
                .end()
                .appendTo('#slideshowsingle');
            },  7000);

        });
