function dj() {
    $.ajax({
        'type' : 'post',
        'url' : '/index/index/famousTags',
        'data':{'classid':classid},
        'success':function(data_ty){
            if(data_ty != 'false'){
                var datas_ty = eval(data_ty);
                var tystr = '';
                $.each(datas_ty,function(index,element_ty){
                    tystr += '<li class="mui-table-view-cell mui-media" v-for="item in items">';
                    tystr += '<a href="' + '/index/index/videoUserinfo?type='+'&video_id='+'"'+':data-guid="item.guid">';
                    tystr += '<img class="mui-media-object mui-pull-left" src="'+'"/>';
                    tystr += '<div class="mui-media-body">';
                    tystr += '<div class="mui-ellipsis-2">'+'发发发'+'</div>';
                    tystr += '</div>';
                    tystr += '<div class="meta-info">';
                    tystr += '<div class="author">'+'</div>';
                    tystr += '</div>';
                    tystr += '<div class="meta-info">' ;
                    tystr += '<div class="pvs" style="float: right;margin-right: 4%;">'+ '浏览量：'+'</div>';
                    tystr += '</div>';
                    tystr += '</a>'+"</li>";
                });
                $('.type3').html(tystr);
            }else{
                //返回空数据
                tystr = '<li></li>';
                $('.type3').html(tystr);
            }
        },
        dateType:'text'
    });
}