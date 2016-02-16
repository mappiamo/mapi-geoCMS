function insta_pages(state, p_id){
    YUI().use('node', 'event', function (mapi_yui){

    	var curr = '#insta_page' + p_id;
        var next = '';

        var count = 0;
        var nodes = mapi_yui.all('.insta_page');
        nodes.each(function(){
            count++;
        });

        var pager = function(curr, next){
            mapi_yui.one(curr).setStyle('display', 'none');
            mapi_yui.one(next).setStyle('display', 'block');
        };

        if(state == 'next'){
            var n_id = Number(p_id) + 1;
            if(p_id == count){
                n_id = 1;
            }
        }
        if(state == 'prev'){
            var n_id = Number(p_id) - 1;
            if(p_id == 1){
                n_id = count;
            }
        }
        next = '#insta_page' + n_id;
        pager(curr, next); 

    });
}