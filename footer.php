<?php wp_footer(); ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/scripts/elmercurio.js.php"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var tw;  $('.carousel').carousel({interval: 4000});
        $.get("<?php bloginfo('template_url'); ?>/clima.php", function(data){ }).done(function(data) { $("#clima").append(data); }).fail(function() { $("#clima").append("");});
        $.getJSON('<?php bloginfo('template_url'); ?>/twitter.php', function(data) { }).done(function(data) {
            var items = []; $.each(data, function(key, val) {items.push('<li id="' + key + '">' + val.text + '</li>');});
                $('<ul/>', {'id':'ticker','class': 'twitem', html: items.join('')}).appendTo('#twitterlist');
                var img = '<img src="https://si0.twimg.com/a/1339639284/images/three_circles/twitter-bird-white-on-blue.png" />';
                $("[rel=popover]").popover({content:img, html:true, content: get_popover_content });
                function tick(){$('#ticker li:first').slideUp( function () { $(this).appendTo($('#ticker')).slideDown(); });}
                tw=setInterval(function(){ tick () }, 10000);
                $('#twitterlist').mouseover(function(){clearInterval(tw);}).mouseout(function(){tw = setInterval(function(){ tick () }, 10000);})
            }).fail(function() { });
        function get_popover_content(){var thisVal=$(this);if ($(this).attr('data-image')) {var img = '<img src="' + $(this).attr('data-image') + '" />';thisVal.attr('data-content',img);}
        }
    });

</script>

</body>
</html>

