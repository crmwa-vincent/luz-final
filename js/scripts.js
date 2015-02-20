
		// $(document).ready(function(){
		// $(".hides").show();
	 // 	 $(".button-hide").click(function(){
		//   $(this).toggle();
		//     });
		// });

		// $(document).ready(function(){
		// $(".shows").hide();
	 // 	 $(".button-hide").click(function(){
		//   $(this).toggle();
		//     });
		// });

function cancel() {
    document.getElementById("textarea").innerHTML = "<textarea name='cancel' placeholder='testing'></textarea>";
    }

function myFunction() {
    var x;
    if (confirm("Do you really want to delete?") == true) {
        x = "Hmmm sige!";
    } else {
        x = "You pressed Cancel!";
    }
}

var italic = 'italic';
var love = 3; 
$(document).ready(function(){
  $("#btn1").click(function(){
    $("p").append(" <b>Appended text</b>.");
     $("p").addClass("italic");
      $("p").attr('id', 'love');
love++;
  });

  $("#btn2").click(function(){
    $("ol").append("<li>Appended item love</li>");
     $("li").addClass("italic");
      $("li").attr('id', 'love');
love++;
  });
  $("#btn3").click(function(){
    $("#love").remove(".italic");
  });
});

$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("slow");
  });
});
