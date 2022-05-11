$(document).ready(function() {
        
            
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    
    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
    });

    // 
    function myFunction1() {

        document.getElementById("myDIV1").style.display = "block";
        
        document.getElementById("myDIV2").style.display = "none";}
        function myFunction2() {
        
        document.getElementById("myDIV1").style.display = "none";
        
        document.getElementById("myDIV2").style.display = "block";}

        // 
        $(document).ready(function() {
            $(".toggle-btn-1 ").click(function() {
                $(".menu-1").hide(2000);
              });
              $(".toggle-btn-2 ").click(function() {
                $(".menu-2").hide(2000);
              });
              $(".toggle-btn-3 ").click(function() {
                $(".menu-3").hide(2000);
              });
              $(".toggle-btn-4 ").click(function() {
                $(".menu-4").hide(2000);
              });
          });