

//REMOVE ADD CLASSE AVEC LE LABEL

 function updateSubject($subj){
    console.log($subj);
    console.log("ici");
     $.ajax({
        url:'/ajax_subject_change',
        type: "POST",
        dataType: "json",
        data: {
            "subject": $subj
        },
        async: true,
        success: function (data)
        {
            console.log(data)
            //$( '#show1' ).text(data.subj);
        }
  })
}


function updateLevel($level){
    console.log($level);
   $.ajax({
        url:'/ajax_level_change',
        type: "POST",
        dataType: "json",
        data: {
            "level": $level
        },
        async: true,
        success: function (data)
        {
            console.log(data)
        }
  })
}





   $('#show1').on('click', function() {
    if ($('#container-quality-1').css('opacity') == 0) {
        document.getElementById("container-quality-1").style.display = "block";
        $('#container-quality-1').css('opacity', 1);
    }else {
        document.getElementById("container-quality-1").style.display = "none";
        $('#container-quality-1').css('opacity', 0);
    }
});



 $('#show2').on('click', function() {
    if ($('#container-quality-2').css('opacity') == 0) {
        document.getElementById("container-quality-2").style.display = "block";
        $('#container-quality-2').css('opacity', 1);
    }else {
        $('#container-quality-2').css('opacity', 0);
        document.getElementById("container-quality-2").style.display = "none";
    }
});

 $('#show3').on('click', function() {
  if ($('#container-quality-3').css('opacity') == 0) {
        document.getElementById("container-quality-3").style.display = "block";
        $('#container-quality-3').css('opacity', 1);
    }else {
        $('#container-quality-3').css('opacity', 0);
        document.getElementById("container-quality-3").style.display = "none";
    }
});

  $('#show4').on('click', function() {
  if ($('#container-quality-4').css('opacity') == 0) {
        document.getElementById("container-quality-4").style.display = "block";
        $('#container-quality-4').css('opacity', 1);
    }else {
        $('#container-quality-4').css('opacity', 0);
        document.getElementById("container-quality-4").style.display = "none";
    }
});

$('#submit1').click( function(){
  console.log($('#quality1').val());
  $quality1 = $('#quality1').val();
   $.ajax({
        url:'/ajax_change_quality',
        type: "POST",
        dataType: "json",
        data: {
            "quality1": $quality1
        },
        async: true,
        success: function (data)
        {
            console.log(data)
            $( '#show1' ).text(data.qual);

        }
  })
});



$('#submit2').click( function(){
  console.log($('#quality2').val());
  $quality2 = $('#quality2').val();
   $.ajax({
        url:'/ajax_change_quality',
        type: "POST",
        dataType: "json",
        data: {
            "quality2": $quality2
        },
        async: true,
        success: function (data)
        {
            console.log(data)
            $( '#show2' ).text(data.qual);
        }
  })
});



$('#submit3').click( function(){
  console.log($('#quality3').val());
  $quality3 = $('#quality3').val();
   $.ajax({
        url:'/ajax_change_quality',
        type: "POST",
        dataType: "json",
        data: {
            "quality3": $quality3
        },
        async: true,
        success: function (data)
        {
            console.log(data)
            $( '#show3' ).text(data.qual);
        }
  })
});





$('#submit4').click( function(){
  console.log($('#quality4').val());
  $quality4 = $('#quality4').val();
   $.ajax({
        url:'/ajax_change_quality',
        type: "POST",
        dataType: "json",
        data: {
            "quality4": $quality4
        },
        async: true,
        success: function (data)
        {
            console.log(data)
            $( '#show4' ).text(data.qual);
        }
  })
});

