function init(){
    var points = [1, 2, 3, 5, 8, 13, "?"];
    var inHTML = '';
    for(var i = 0; i < points.length; i++){
        inHTML += '<li>';
        inHTML += '     <div class="poker m">';
        inHTML += '         <div class="name">Points</div>';
        inHTML += '         <div class="point">' + points[i] + '</div>';
        inHTML += '     </div>';
        inHTML += '</li>';
    }
    $("ul.options").html(inHTML);
}

function addOthers(name, point){
    var tbdClass = "";
    if("?" === point){
        tbdClass = "tbd";
    }
    var inHTML = "";
    inHTML += '<li>';
    inHTML += '     <div class="poker m ' + tbdClass + '">';
    inHTML += '         <div class="name">' + name + '</div>';
    inHTML += '         <div class="point">' + point + '</div>';
    inHTML += '     </div>';
    inHTML += '</li>';

    $("ul.others").append(inHTML);
}

function refresh(){
    $.post("apps/info.php", {
        method: "get",
        roomId: "1"
    }, function(data){
        var data = JSON.parse(data);
        if(data && data.length){
            $("ul.others").html("");
            var myname = $(".main .l .name").text();
            var mypoint = $(".main .l .point").text();
            for(var i = 0; i < data.length; i++){
                var name = data[i].member;
                var point = data[i].point;
                if( mypoint === "?" || (name === myname && point === "?") || typeof point === "undefined"){
                    addOthers(name, "?");
                    $(".main .l .point").text("?");
                }else{
                    addOthers(name, point);
                }
            }
        }
    });

    setTimeout(function() {
        refresh();
    }, 2000);
}

function setPoints(){
    $.post("apps/info.php", {
        name: $(".main .l .name").text(),
        points: $(".main .l .point").text(),
        roomId: "1",
        method: "set"
    }, function(data){
        var data = JSON.parse(data);
        var points = data.points;
        if(points){
            $("ul.others").html("");
            for(var name in points){
                addOthers(name, points[name]);
            }
        }
    });
}

function resetPoints(){
    $.post("apps/info.php", {
        method: "reset"
    }, function(data){
        var data = JSON.parse(data);
        var points = data.points;
        if(points){
            $("ul.others").html("");
            for(var name in points){
                addOthers(name, points[name]);
            }
        }
    });
}

function clearPoints(){
    $.post("apps/info.php", {
        method: "clear"
    }, function(data){
        var data = JSON.parse(data);
        var points = data.points;
        $("ul.others").html("");
        for(var name in points){
            addOthers(name, points[name]);
        }
    });
}

function login(){
    var user = $(".msg input").val();
    if(user && user.length > 0){
        $(".main .l .name").text(user);
        $(".msg").fadeOut();
        $(".mask").fadeOut();
        $.post("apps/info.php", {
            name: $(".main .l .name").text(),
            points: "?",
            method: "set"
        }, function(data){
           
        });
    }else{
        $(".msg .content").css("color", "orange");
    }
}

function observe(){
    $(".main .l .name").text("Observer");
    $(".msg").fadeOut();
    $(".mask").fadeOut();
    $(".second .poker.m").addClass("disabled");
    $(".main .l.poker").addClass("disabled observer");
    $(".operations").addClass("observer");
}

$(document).ready(function(){
    init();

    $(".poker.l").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        var self = $(this);
        if(self.hasClass("disabled")){
            return;
        }
        self.find(".point").text("?");
        setPoints();
    });

    $(".poker.m").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        var self = $(this);
        if(self.hasClass("disabled")){
            return;
        }
        var point = self.find(".point").text();
        $(".poker.l .point").text(point);
        setPoints();
    });

    $(".reset").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        $(".poker.l").find(".point").text("?");
        resetPoints();
    });

    $(".clear").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        clearPoints();
    });

    $(".msg .msg-btn").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        login();
    });

    $(".msg .msg-ob").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        observe();
    });

    $(".msg input").on("keyup", function(e){
        e.preventDefault();
        e.stopPropagation();
        if(13 === e.keyCode){
            login();
        }   
    });

    $(".msg").show().css({
        left: $(window).width()/2-$(".msg").width()/2 + "px",
        top: $(window).height()/2-$(".msg").height()/2 + "px"
    });

    $(".msg input").focus();


    refresh();
});