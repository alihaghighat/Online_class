function addStudentToClass() {


    var checkedStudents = [];
    $('.student').each(function() {
        if (this.checked) {

            checkedStudents.push($(this).val())
        }
    })


    var stringed = JSON.stringify(checkedStudents);


    $.ajax({
        url: '../functions/add-student-to-class.php',
        type: "POST",

        data: {
            'idclass': <?php echo $_REQUEST['idclass'] ?>,
            'students': stringed,

        },
        success: function(data) {
            alert(data);
            location.replace("../page/Class_list");
        }

    });

}