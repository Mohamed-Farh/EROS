
//add building ads
$(document).ready(function () {
    $(".add-buildings ").click(function () {
        $(".add-buildings-ads-sec").toggle(2000);
    });
});
//add car ads
$(document).ready(function () {
    $(".add-car ").click(function () {
        $(".add-car-ads-sec").toggle(2000);
    });
});
//add products ads
$(document).ready(function () {
    $(".add-productss ").click(function () {
        $(".add-products-ads-sec").toggle(2000);
    });
});
//add services ads
$(document).ready(function () {
    $(".add-services ").click(function () {
        $(".add-services-ads-sec").toggle(2000);
    });
});
//add doctors ads
$(document).ready(function () {
    $(".add-doctors ").click(function () {
        $(".add-doctors-ads-sec").toggle(2000);
    });
});
//add medicines ads
$(document).ready(function () {
    $(".add-medicines ").click(function () {
        $(".add-medicines-ads-sec").toggle(2000);
    });
});
// favorite heart icon
var buttons = document.getElementsByClassName("like-button");
for (var i = 0; i < buttons.length; i++) {
    buttons.item(i).addEventListener("click", doLikeButton);
}
function doLikeButton(e) {
    toggleButton(e.target);
}
function toggleButton(button) {
    button.classList.remove('liked-shaked');
    button.classList.toggle('liked');
    button.classList.toggle('not-liked');
    button.classList.toggle('fa-heart-o');
    button.classList.toggle('fa-heart');
    if (button.classList.contains("liked")) {
        button.classList.add('liked-shaked');
    }
}
function myFunction(imgs) {
    var expandImg = document.getElementById("expandedImg");
    var imgText = document.getElementById("imgtext");
    expandImg.src = imgs.src;
    imgText.innerHTML = imgs.alt;
    expandImg.parentElement.style.display = "block";
}

