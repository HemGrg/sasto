
<script>

$(document).ready(function() {

  $("#fileUpload").on('change', function () {

    if (typeof (FileReader) != "undefined") {

     var image_holder = $("#image-holder");

     // $("#image-holder").siblings().remove();

     $("#image-holder").children().remove();

     var reader = new FileReader();
     reader.onload = function (e) {

         $("<img />", {
             "src": e.target.result,
             "class": "thumb-image",
             "width" : '50%'
         }).appendTo(image_holder);

     }
     image_holder.show();
     reader.readAsDataURL($(this)[0].files[0]);
 } else {
     alert("This browser does not support FileReader.");
 }
});

});

</script>
