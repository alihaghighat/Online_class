function openLink(url) {
    window.location = "../"+url;
}

function hidepopup(){
    $('#modd').modal('hide');
}

function shpopup(titlehtml, bodyhtml) {

    $('#modd .modal-dialog .modal-content .modal-header .head').html(titlehtml);
    $('#modd .modal-dialog .modal-content .modal-body').html(bodyhtml);
    $("#modd").modal();

}

function showSuccessAlert(text){
document.getElementById("success-alert").innerHTML = text;
$("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
    $("#success-alert").slideUp(500);
});
}

function showDangerAlert(text){
document.getElementById("danger-alert").innerHTML = text;
$("#danger-alert").fadeTo(2000, 500).slideUp(500, function() {
    $("#danger-alert").slideUp(500);
});
}