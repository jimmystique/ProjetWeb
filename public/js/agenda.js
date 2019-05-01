
function getWeekNumber(d) {
    d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));
    d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay()||7));
    var yearStart = new Date(Date.UTC(d.getUTCFullYear(),0,1));
    // Calculate full weeks to nearest Thursday
    var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
    return [d.getUTCFullYear(), weekNo];
}

var result = getWeekNumber(new Date());
console.log('It\'s currently week ' + result[1] + ' of ' + result[0]);
 $( '#week' ).text("Semaine n°" + result[1]);
 $actual_week = result[1];



//RAFRAICHIT L'AGENDA EN SUPPRIMANT LES NOMS
function refreshHour($val){
     $type = $val.replace( /^\D+/g, '');

     switch($type){
      case "1":
        $($val).text(" 9h00 - 9h30 ");break;

      case "2" :
        $($val).text(" 9h30 - 10h00 ");break;

      case "3":
        $($val).text(" 10h00 - 10h30 ");break;

      case "4" :
        $($val).text(" 10h30 - 11h00 ");break;

      case "5" :
        $($val).text(" 11h00 - 11h30 ");break;

      case "6":
        $($val).text(" 11h30 - 12h00 ");break;

      case "7" :
        $($val).text(" 12h00 - 12h30 ");break;

      case "8":
        $($val).text(" 12h30 - 13h00 ");break;

       case "9" :
        $($val).text(" 13h00 - 13h30 ");break;

       case "10":
        $($val).text(" 13h30 - 14h00 ");break;

      case "11" :
        $($val).text(" 14h00 - 14h30 ");break;

      case "12":
        $($val).text(" 14h30 - 15h00 ");break;

      case "13" :
        $($val).text(" 15h00 - 15h30 ");break;

       case "14" :
        $($val).text(" 15h30 - 16h00 ");break;

        case "15":
        $($val).text(" 16h00 - 16h30 ");break;

      case "16" :
        $($val).text(" 16h30 - 17h00 ");break;

      case "17":
        $($val).text(" 17h00 - 17h30 ");break;

      case "18" :
        $($val).text(" 17h30 - 18h00 ");break;

       case "19" :
        $($val).text(" 18h00 - 18h30 ");break;

      case "20" :
        $($val).text(" 18h30 - 19h00 ");break;

        default: ;

     }


}

function refreshAgenda(){
  for($i = 1; $i < 21; $i++){
    document.getElementById('lu'+$i).className = "btn btn-secondary  col-12 col-sm-2 col-md-2 col-lg-12";
    refreshHour('#lu'+$i);
    document.getElementById('ma'+$i).className = "btn btn-secondary  col-12 col-sm-2 col-md-2 col-lg-12";
    refreshHour('#ma'+$i);
    document.getElementById('me'+$i).className = "btn btn-secondary  col-12 col-sm-2 col-md-2 col-lg-12";
    refreshHour('#me'+$i);
    document.getElementById('je'+$i).className = "btn btn-secondary  col-12 col-sm-2 col-md-2 col-lg-12";
    refreshHour('#je'+$i);
    document.getElementById('ve'+$i).className = "btn btn-secondary  col-12 col-sm-2 col-md-2 col-lg-12";
    refreshHour('#ve'+$i);
    document.getElementById('sa'+$i).className = "btn btn-secondary  col-12 col-sm-2 col-md-2 col-lg-12";
    refreshHour('#sa'+$i);

  }

}




function changeState($val){
     $week = $( '#week' ).text().replace( /^\D+/g, '');
     if($week < $actual_week){
         $( '#message_change' ).text("Vous ne pouvez pas modifier les jours des semaines passées");
         $('#message_change').css('color','red');
      return ;
    }

    if(document.getElementById($val).classList.contains('btn-secondary')){
        //AJOUT D'UNE DATE DE DISPO
        console.log("AJOUT DANS LA BASE : ");
        console.log("WEEK : " + $week);
        console.log("JOUR " + $val);
        $("#"+$val).removeClass('btn-secondary');
        $("#"+$val).addClass("btn-success");
        $.ajax({
            url:'/ajax_agenda_change',
            type: "POST",
            dataType: "json",
            data: {
                "week": $week,
                "val": $val
            },
            async: true,
            success: function (data)
            {
                console.log(data)
            },
            error : function(err){
              alert(err)
            }
         })
    }else if(document.getElementById($val).classList.contains('btn-success')){
        $("#"+$val).removeClass("btn-success");
        $("#"+$val).addClass("btn-warning");

    }else if(document.getElementById($val).classList.contains('btn-warning')){
      //ON SUPPRIME
      $("#"+$val).removeClass("btn-warning");
      $("#"+$val).addClass("btn-secondary");
       $.ajax({
            url:'/ajax_agenda_delete',
            type: "POST",
            dataType: "json",
            data: {
                "week": $week,
                "val": $val
            },
            async: true,
            success: function (data)
            {
                console.log(data)
            },
            error : function(err){
              alert(err)
            }
         })
       refreshHour("#"+$val);

    }
}

