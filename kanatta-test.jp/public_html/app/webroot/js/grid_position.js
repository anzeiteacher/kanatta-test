function all_grid_position() {
    if($('.top_content').length >0){
        $('.top_content').each(function(idx){
            grid_position(idx);
        });
    }else{
        grid_position(null, 'not_top');
    }
}
function grid_position(idx, not_top) {
    var border_w = 10;
    var w = $(window).width();
    if(!not_top){
        var top_content = '.top_content[name='+idx+'] ';
    }else{
        var top_content = '';
    }
    var grid_wrap = top_content+'.grid_wrap';
    var grid_container = top_content+'.grid_container';
    if (w > 711) {
    	if (w > 1200) {w = 1200;}
        var grid_lp = 10;
        var grid_iw = 300;
        var grid_w = grid_iw + grid_lp;
        if (w < grid_w * $(grid_wrap).length + border_w) {
            var grid_num = Math.floor((w - border_w) / grid_w);
            var space = (w - border_w) % grid_w;
            if (grid_num < $(grid_wrap).length) {
                grid_num++;
                space = (grid_w - space) / grid_num;
                grid_w -= space;
                $(grid_wrap).width(grid_w - grid_lp);
            }
            $(grid_container).width(grid_w * grid_num + border_w);
        } else {
            $(grid_container).width(grid_w * $(grid_wrap).length + border_w);
        }
    } else {
        $(grid_container).width('100%');
    }
}

function grid_position_report() {
    var border_w = 10;
    var w = $(window).width();
    if (w > 700) {
        var grid_lp = 10;
        var grid_iw = 400;
        var grid_w = grid_iw + grid_lp;
        if (w < grid_w * $('.grid_wrap_report').length + border_w) {
            var grid_num = Math.floor((w - border_w) / grid_w);
            var space = (w - border_w) % grid_w;
            if (grid_num < $('.grid_wrap_report').length) {
                grid_num++;
                space = (grid_w - space) / grid_num;
                grid_w -= space;
                $('.grid_wrap_report').width(grid_w - grid_lp);
            }
            $('#grid_container_report').width(grid_w * grid_num + border_w);
        } else {
            $('#grid_container_report').width(grid_w * $('.grid_wrap_report').length + border_w);
        }
    } else {
        $('#grid_container_report').width('100%');
    }
}

function top_report_position() {
    var border_w = 10;
    var w = $(window).width();
    $('.grid_wrap_report').width($('.grid_wrap').width());
    var grid_w = $('.grid_wrap_report').width() + border_w;
    if (w > 700) {
        if (w > grid_w * $('.grid_wrap_report').length + border_w) {
            $('#grid_container_report').width(grid_w * $('.grid_wrap_report').length + border_w);
        }
    }
}