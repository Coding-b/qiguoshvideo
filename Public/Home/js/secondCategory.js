/**
 * Created by bingo on 2014/9/21.
 */
$(document).ready(function(){
    var time = null;
    var list = $(".navlist");
    var box = $("#nav-box");
    var lista = list.find("li");

    for(var i=0,j=lista.length;i<j;i++){
        if(lista[i].className == "now"){
            var olda = i;
        }
    }

    var box_show = function(hei){
        box.stop().animate({
            height:hei,
            opacity:1
        },400);
    }

    var box_hide = function(){
        box.stop().animate({
            height:0,
            opacity:0
        },400);
    }

    lista.hover(function(){
        var index = list.find("li").index($(this));
        if(index != 0){
            lista.removeClass("now");
            $(this).addClass("now");
            clearTimeout(time);
            index -= 1;
            box.find(".cont").hide().eq(index).show();
            var _height = 40;
            box.find(".cont").eq(index).position
            box_show(_height)
        }
    },function(){
        time = setTimeout(function(){
            box.find(".cont").hide();
            box_hide();
        },50);
        lista.removeClass("now");
        lista.eq(olda).addClass("now");
    });

    box.find(".cont").hover(function(){
        var _index = box.find(".cont").index($(this));
        lista.removeClass("now");
        lista.eq(_index).addClass("now");
        clearTimeout(time);
        $(this).show();
        var _height = 40;
        box_show(_height);
    },function(){
        time = setTimeout(function(){
            $(this).hide();
            box_hide();
        },50);
        lista.removeClass("now");
        lista.eq(olda).addClass("now");
    });

});