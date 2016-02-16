/**
 * Created by Laca on 2015.05.26..
 */

$(document).ready(function() {

    function trim(str){
        var str=str.replace(/^\s+|\s+$/,'');
        return str;
    }

    //var rootpath = window.location.pathname.substring(0, window.location.pathname.lastIndexOf("/")) + '/';
    var rootpath = SiteRoot;
    //alert(rootpath);

    $("#readbutton").click(function(e) {

        $("#display_result").empty();

        $.ajax({
            type: 'POST',
            url: rootpath + 'ajax/AjaxDemo.php',
            data: { action: 'read' },
            success: function (data) {
                //alert(data);

                var names = data;
                var json = $.parseJSON(names);

                $(json).each(function(ind, val){
                    $("#display_result").append('<li>' + val['PID'] + ' -> ' + val['TheContent'] + ' -> ' + val['Enabled']  + '</li>');
                });

            }
        });

    });

    $("#writebutton").click(function(e) {

        var thestring = $('#textarea').val();

        //alert(thestring);

        $.ajax({
            type: 'POST',
            url: rootpath + 'ajax/AjaxDemo.php',
            data: { action: 'write', datavalue: thestring },
            //dataType: 'json',
            success: function (data) {
                //alert(data);

                var names = trim(data);
                if (names.length > 0) {
                    $("#display_result").empty();
                }

                var json = $.parseJSON(names);

                $(json).each(function(ind, val){
                   $("#display_result").append('<li>' + val['PID'] + ' -> ' + val['TheContent'] + ' -> ' + val['Enabled']  + '</li>');
                });

            }
        });

    });

});
