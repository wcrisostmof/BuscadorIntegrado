$(function() {
    $('#nav li a').click(function() {
       $('#nav li').removeClass();
       $($(this).attr('href')).addClass('active');
    });
});

function submitFormInPopUp(){
    var url = "Idweb.php?iweb=" + document.getElementsByTagName('input')[0].value;
    window.open(url, width=900,height=500);
}