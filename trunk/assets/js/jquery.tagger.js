(function($){

    $.fn.addTag = function(v){
        var r = v.split(',');
        for(var i in r){
            n = r[i];//.replace(/([^a-zA-Z0-9ŠšĐđŽžČčĆćЉљЊњЕеРрТтЗзУуИиОоПпШшЂђЖжАаСсДдФфГгХхЈјКкЛлЧчЋћЏџЦцВвБбНнМм\s\-\_])|^\s|\s$/g, '');
            if(n == '') return false;
            var fn = $(this).data('name');
            var i = $('<input type="hidden" />').attr('name',fn).val(n);
            var t = $('<li />').text(n).addClass('tagName')
            .click(function(){
                // remove
                var hidden = $(this).data('hidden');
                $(hidden).remove();
                $(this).remove();
            })
            .data('hidden',i);
            var l = $(this).data('list');
            $(l).append(t).append(i);
        }
    };
})(jQuery);