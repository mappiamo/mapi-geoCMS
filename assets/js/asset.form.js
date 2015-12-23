function MFrm() {

    this.module = '';
    this.task = '';
    this.obj = '';

    this.request = function (dtype, uri_append) {
        var action_uri = 'index.php?module=' + this.escape_uri(this.module) + '&task=' + this.escape_uri(this.task) + '&object=' + this.escape_id(this.obj);

        action_uri += '&' + uri_append;
        action_uri += '&mapi_csrf=' + this.escape_uri(this.mapi_csrf());

        //alert(action_uri); return;

        $.ajax({
            url: action_uri,
            dataType: dtype
        }).done(function (result) {
            //alert(result); return;
            location.reload();
        });
    }

    this.mapi_csrf = function () {
        if (!$('#mapi_csrf') || !$('#mapi_csrf').val()) return '';

        return $('#mapi_csrf').val();
    }

    this.escape_numeric = function (input) {
        return input.replace(/[^0-9]/, '');
    }

    this.escape_id = function (input) {
        return Math.abs(this.escape_numeric(input.replace(/[^0-9]/, '')));
    }

    this.escape_uri = function (input) {
        return encodeURIComponent(input);
    }

}

function MMWizard() {

    this.module = 'mcontent';

    this.add_bulk_meta = function () {
        alert('meta wizard client');
    }
}

function MContent() {

    this.module = 'mcontent';

    if ($('#content_id') && $('#content_id').val()) {
        this.obj = $('#content_id').val();
    }

    this.add_category = function () {
        if (!$('#content_category') || !$('#content_category').val()) return null;

        this.task = 'content_category';
        var uri = 'category_add=1&category_id=' + this.escape_id($('#content_category').val());

        this.request('html', uri);
    }

    this.remove_category = function (category_id) {
        this.task = 'content_category';
        var uri = 'category_remove=1&category_id=' + this.escape_id(category_id);

        this.request('html', uri);
    }

    this.add_meta = function () {
        if (!$('#meta_name') || !$('#meta_name').val()) return null;
        if (!$('#meta_value') || !$('#meta_value').val()) return null;

        this.task = 'content_meta';
        var uri = 'meta_add=1&meta_name=' + this.escape_uri($('#meta_name').val()) + '&meta_value=' + this.escape_uri($('#meta_value').val());

        this.request('html', uri);
    }

    this.remove_meta = function (meta_name) {
        this.task = 'content_meta';
        var uri = 'meta_remove=1&meta_name=' + this.escape_uri(meta_name);

        this.request('html', uri);
    }

    this.default_media = function (media_id) {
        this.task = 'content_media';
        var uri = 'media_default=1&media_id=' + this.escape_id(media_id);

        this.request('html', uri);
    }

    this.add_media = function (content_id) {
        var action_uri = 'index.php?module=mcontent&task=content_media&object=' + this.escape_uri(content_id) + '&media_add=1';
        action_uri += '&mapi_csrf=' + this.escape_uri(this.mapi_csrf());

        $('#dropzone-images').dropzone({
            url: action_uri,
            paramName: 'file',
            maxFilesize: 2,
            success: function () {
                location.reload();
            }
        });
    }

    this.remove_media = function (media_id) {
        this.task = 'content_media';
        var uri = 'media_remove=1&media_id=' + this.escape_id(media_id);

        this.request('html', uri);
    }

    this.setup_table = function (table) {
        $('#' + table).dataTable({
            'aaSorting': [
                [ 0, 'desc' ]
            ]
        });
    }

    this.nosort_column = function (table, column, firstsort) {
        $('#' + table).dataTable({
            'aaSorting': [
                [ firstsort, 'asc' ]
            ],
            'aoColumnDefs': [
                { "bSortable": false, "aTargets": [ column ] }
            ]
        });
    }

    this.setup_meta_table = function () {
        $('#content_meta').dataTable({
            'aaSorting': [
                [ 0, 'desc' ]
            ],
            'aoColumnDefs': [
                { "bVisible": false, "aTargets": [ 0 ] },
                { "bSortable": false, "aTargets": [ 3 ] }
            ]
        });
    }

    this.type_select = function () {
        var tab = '';
        var c_type = '';

        if ($.cookie('last_tab')) tab = $.cookie('last_tab');

        if (tab && $('a[href=' + tab + ']').length) {
            c_type = $('a[href=' + tab + ']').html();
        } else {
            c_type = $('a[data-toggle="tab"]:first').html();
        }

        if (c_type.length > 0) c_type = this.escape_uri(c_type);
        c_type = c_type.toLowerCase();

        if ($('#content_type')) $('#content_type').val(c_type);
    }

}

function MModule() {

    this.module = 'mmodule';

    this.install = function (name) {
        this.task = 'module_install';
        var uri = 'module_action=1&name=' + this.escape_uri(name);

        this.request('html', uri);
    }

    this.enable = function (module_id) {
        this.obj = module_id;
        this.task = 'module_enable';
        var uri = '&module_action=1';

        this.request('html', uri);
    }

    this.disable = function (module_id) {
        this.obj = module_id;
        this.task = 'module_disable';
        var uri = '&module_action=1';

        this.request('html', uri);
    }
}

function MTemplate() {

    this.module = 'mtemplate';

    this.install = function (name) {
        this.task = 'template_install';
        var uri = 'template_action=1&name=' + this.escape_uri(name);

        this.request('html', uri);
    }

    this.enable = function (template_id) {
        this.obj = template_id;
        this.task = 'template_enable';
        var uri = '&template_action=1';

        this.request('html', uri);
    }

    this.disable = function (template_id) {
        this.obj = template_id;
        this.task = 'template_disable';
        var uri = '&template_action=1';

        this.request('html', uri);
    }
}

function MWidget() {

    this.module = 'mwidget';

    this.install = function (name) {
        this.task = 'widget_install';
        var uri = 'widget_action=1&name=' + this.escape_uri(name);

        this.request('html', uri);
    }

    this.enable = function (widget_id) {
        this.obj = widget_id;
        this.task = 'widget_enable';
        var uri = '&widget_action=1';

        this.request('html', uri);
    }

    this.disable = function (widget_id) {
        this.obj = widget_id;
        this.task = 'widget_disable';
        var uri = '&widget_action=1';

        this.request('html', uri);
    }
}

function MPage() {

    this.module = 'mpage';
    this.base_url = '';

    if ($('#page_id') && $('#page_id').val()) {
        this.obj = $('#page_id').val();
    }

    this.add_content_url = function () {
        var content_id = "";

        var selected = $("input[type='radio'][name='content_list']:checked");
        if (selected.length > 0) {
            content_id = selected.val();
        }

        var url = ''; //this.base_url;
        if (content_id) url += 'index.php?module=content&object=' + content_id;

        $('#page_url').val(url);
        $('#page_type').val('content');
    }

    this.add_category_url = function () {
        var category_id = "";

        var selected = $("input[type='radio'][name='category_list']:checked");
        if (selected.length > 0) {
            category_id = selected.val();
        }

        var url = ''; //this.base_url;
        //var pathname = window.location.pathname;
        //var pathname = window.location.pathname.split('/')[1] + "/";
        //var pathname = window.location.pathname.substring(0, window.location.pathname.lastIndexOf("/"));
        //alert(url);

        if (category_id) url += 'index.php?module=category&object=' + category_id;

        $('#page_url').val(url);
        $('#page_type').val('category');
    }

    this.add_event_url = function (PID) {
        var events = "";

        var events = $("input[type='checkbox'][name='event_list']:checked").map(function () {
            return this.value;
        }).get();

        var url = ''; //this.base_url;

        if (events.length > 0) {
            url += 'index.php?module=event&object={' + events + '}';
        } else {
            url += 'index.php?module=event&object={All}';
        }

        var addthis = {};

        addthis.sort = $("[name='sort']").val();
        addthis.reverse_order = $("[name='reverse_order']:checked").val();

        var filter_type = $("[name='filter_type']").val();

        if (filter_type == 'fix') {
            addthis.filter_start = $("[name='filter_start']").val();
            addthis.filter_end = $("[name='filter_end']").val();
            addthis.filterby = $("[name='filterby']").val();
        } else {
            addthis.filter = $("[name='filter']").val();
            addthis.expired = $("[name='expired']").val();
            addthis.filterby = $("[name='filterby']").val();
        }

        addthis.user_filter = $("[name='user_filter']:checked").val();

        addthis.address = $("[name='address']").val();
        addthis.filter_radius = $("[name='filter_radius']").val();

        $.each(addthis, function (key, value) {
            if ((typeof value != 'undefined') && (value.length > 0)) {
                url += '&' + key + '=' + value;
            }
        });

        url += '&pid=' + PID;

        $('#page_url').val(url);
        $('#page_type').val('event');
    }


    this.add_module_url = function () {
        var module_name = $("[name='module_name']").find(':selected').val();
        var module_task = $("[name='module_task']").val();

        var url = ''; //this.base_url;
        if (module_name.length > 0) url += 'index.php?module=' + module_name;
        if (module_task.length > 0) url += '&task=' + module_task;

        $('#page_url').val(url);
        $('#page_type').val('module');
    }


    this.add_menu = function () {
        if (!$('#page_menu') || !$('#page_menu').val()) return null;

        this.task = 'page_menu';
        if ($('#page_menu').val() === parseInt($('#page_menu').val(), 10)) {
            var uri = 'menu_add=1&menu_id=' + this.escape_id($('#page_menu').val());
        } else {
            var uri = 'menu_add=1&menu_id=' + ( $('#page_menu').val() );
        }
        //alert(uri); return;

        this.request('html', uri);
    }

    this.remove_menu = function (menu_id) {
        this.task = 'page_menu';
        if ($('#page_menu').val() === parseInt($('#page_menu').val(), 10)) {
            var uri = 'menu_remove=1&menu_id=' + this.escape_id(menu_id);
        } else {
            var uri = 'menu_remove=1&menu_id=' + (menu_id);
        }

        this.request('html', uri);
    }
}

MContent.prototype = new MFrm();
MModule.prototype = new MFrm();
MTemplate.prototype = new MFrm();
MWidget.prototype = new MFrm();
MPage.prototype = new MFrm();
MMWizard.prototype = new MFrm();

$(document).ready(function () {
    $(".leaflet-routing-container").hide();

    /* var picker_start = new Pikaday({
     field: document.getElementById('content_start'),
     showWeekNumber: true,
     firstDay: 1,
     format: 'YYYY-MM-DD',
     showMonthAfterYear: true,
     yearRange: [1900,2030]
     });

     var picker_end = new Pikaday({
     field: document.getElementById('content_end'),
     showWeekNumber: true,
     firstDay: 1,
     format: 'YYYY-MM-DD',
     showMonthAfterYear: true,
     yearRange: [1900,2030]
     }); */

    $("#address").autocomplete("./../modules/event/ajax/GetAddressList.php", {
        width: 300,
        matchContains: true,
        mustMatch: true,
        //minChars: 0,
        //multiple: true,
        //highlight: false,
        //multipleSeparator: ",",
        selectFirst: false
    });

    $("#fix_filters").hide();
    $("#filter_type").change(function () {
        var valueSelected = this.value;
        if (valueSelected == 'fix') {
            $("#fix_filters").show();
            $("#active_filters").hide();
            /* $("#fix_filters input").val(''); */
        } else {
            $("#fix_filters").hide();
            $("#active_filters").show();
        }
    });

    var enddate = $('#filter_end').val();
    var startdate = $('#filter_start').val();

    $('#filter_start').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'en',
        dayViewHeaderFormat: 'YYYY MMMM',
        minDate: '2014',
        calendarWeeks: true,
        showTodayButton: true,
        showClear: true,
        showClose: true
    }).on('event-chooser', function (event) {
        event.stopPropagation();
    });

    $('#filter_end').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'en',
        dayViewHeaderFormat: 'YYYY MMMM',
        minDate: '2014',
        calendarWeeks: true,
        showTodayButton: true,
        showClear: true,
        showClose: true
    }).on('event-chooser', function (event) {
        event.stopPropagation();
    });

    if (startdate) {
        $('#filter_end').data("DateTimePicker").minDate(startdate);
    }
    $("#filter_start").on("dp.change", function (e) {
        $('#filter_end').data("DateTimePicker").minDate(e.date);
    });

    if (enddate) {
        $('#filter_start').data("DateTimePicker").maxDate(enddate);
    }
    $("#filter_end").on("dp.change", function (e) {
        $('#filter_start').data("DateTimePicker").maxDate(e.date);
    });

    var event_enddate = $('#content_end').val();
    var event_startdate = $('#content_start').val();

    $('#content_start').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'en',
        dayViewHeaderFormat: 'YYYY MMMM',
        minDate: '2014',
        calendarWeeks: true,
        showTodayButton: true,
        showClear: true,
        showClose: true
    });

    $('#content_end').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
        locale: 'en',
        dayViewHeaderFormat: 'YYYY MMMM',
        minDate: '2010',
        calendarWeeks: true,
        showTodayButton: true,
        showClear: true,
        showClose: true
    });

    if (event_startdate) {
        $('#content_end').data("DateTimePicker").minDate(event_startdate);
    }
    $("#content_start").on("dp.change", function (e) {
        $('#content_end').data("DateTimePicker").minDate(e.date);
    });

    if (event_enddate) {
        $('#content_start').data("DateTimePicker").minDate(event_enddate);
    }
    $("#content_end").on("dp.change", function (e) {
        $('#content_start').data("DateTimePicker").maxDate(e.date);
    });

    $('#content_address').bind("keyup keypress", function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#meta_name').keypress(function (e) {
        if (13 == e.keyCode) {
            $('#meta_add').click();
            return false;
        }
        $("#meta_panel span#FinalError").hide();
    });

    $('#meta_value').keypress(function (e) {
        if (13 == e.keyCode) {
            $('#meta_add').click();
            return false;
        }
        $("#meta_panel span#FinalError").hide();
    });

    $("#meta_add").click(function (event) {

        function isValidMetaName(Name) {
            var namepattern = new RegExp(/^[a-zA-Z0-9éáűúőóüöíÉÁŰŐÚÓÜÖÍèçòàùì£ÈÀÒÙÌñÑ’‘'"\-.,:()\&\/ ]{3,30}$/i);
            return namepattern.test(Name);
        };

        function isValidMetaVal(MVal) {
            var namepattern = new RegExp(/^[a-zA-Z0-9éáűúőóüöíÉÁŰŐÚÓÜÖÍèçòàùì£ÈÀÒÙÌñÑ’‘'"\-_!?.,:;(){}\[\]\@\#\$\%\&\*\/ ]{1,30}$/i);
            return namepattern.test(MVal);
        };

        var metaname = $('#meta_panel #meta_name').val();
        var metaval = $('#meta_panel #meta_value').val();

        var error_mn = 1;
        var error_mv = 1;

        if ((metaname.length < 3) || (isValidMetaName(metaname) == false)) {
            $("#meta_panel .FinalError").css('background-color', "#D54A4D");
            $("#meta_panel span#FinalError").html('Meta name short or syntax error');
            error_mn = 1;
        } else {
            error_mn = 0;
        }

        if ((metaval.length < 1) || (isValidMetaVal(metaval) == false)) {
            $("#meta_panel .FinalError").css('background-color', "#D54A4D");
            $("#meta_panel span#FinalError").html('Meta value empty or syntax error');
            error_mv = 1;
        } else {
            error_mv = 0;
        }

        if ((error_mv + error_mn) == 0) {
            $("#meta_panel .FinalError").css('background-color', "#2BCC27");
            $("#meta_panel span#FinalError").html('Meta data input ok...');
            $("#meta_panel span#FinalError").show();
        } else {
            $("#meta_panel span#FinalError").show();
            return false;
        }
    });

    $('#RouteTab').click(function (e) {
        if (map.hasLayer(draw_layer)) {
            draw_layer.clearLayers();
        }
        $(".leaflet-draw").hide();
        $(".leaflet-routing-container").show();
    });

    $('#PostTab').click(function (e) {
        routeControl.getPlan().setWaypoints({latLng: L.latLng(null)});
        $(".leaflet-draw").show();
        $(".leaflet-routing-container").hide();
    });

    $('#PlaceTab').click(function (e) {
        routeControl.getPlan().setWaypoints({latLng: L.latLng(null)});
        $(".leaflet-draw").show();
        $(".leaflet-routing-container").hide();
    });

    $('#EventTab').click(function (e) {
        routeControl.getPlan().setWaypoints({latLng: L.latLng(null)});
        $(".leaflet-draw").show();
        $(".leaflet-routing-container").hide();
    });
});