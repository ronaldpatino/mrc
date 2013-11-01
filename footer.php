<?php wp_footer(); ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.carousel').carousel({
            interval: 4000
        });

        $.get("<?php bloginfo('template_url'); ?>/clima.php", function(data) { })
            .done(function(data) { $("#clima").append(data); })
            .fail(function() { $("#clima").append(""); });



        $.getJSON('<?php bloginfo('template_url'); ?>/twitter.php', function(data) { })
            .done(function(data) {  var items = [];
                $.each(data, function(key, val) {items.push('<li id="' + key + '">' + val.text + '</li>');});
                $('<ul/>', {'id':'ticker','class': 'twitem', html: items.join('')}).appendTo('#twitterlist');
                function tick(){
                    $('#ticker li:first').slideUp( function () { $(this).appendTo($('#ticker')).slideDown(); });
                }
                setInterval(function(){ tick () }, 10000);
            })
            .fail(function() { });

    });
</script>

</body>
</html>

