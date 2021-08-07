function BulckStudentToClass(id) {



    $.ajax({
        url: '../functions/list-student-to-class.php',
        type: "POST",

        data: {
            'idcalss': <?php echo $_REQUEST['idcalss'] ?>,
            'idstude': id,
            'actions': 'Bluck',

        },
        success: function(data) {
            showSuccessAlert(data);
            location.reload();


        }

    });

}
function UnBulckStudentToClass(id) {



    $.ajax({
        url: '../functions/list-student-to-class.php',
        type: "POST",

        data: {
            'idcalss': <?php echo $_REQUEST['idcalss'] ?>,
            'idstude': id,
            'actions': 'unBluck',

        },
        success: function(data) {
            showSuccessAlert(data);
            location.reload();


        }

    });

}