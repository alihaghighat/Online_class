function addScore(idchat) {
    var score = $("#score").val();
    $.ajax({
        url: 'functions/addScoreToAnswer.php',
        type: 'post',
        data: {
            'idchat': idchat,
            'score': score
        },
        success: function(data) {
            if (data == 'true') {
                hidepopup();
            } else {
                showDangerAlert(data);
            }
        }
    });
}