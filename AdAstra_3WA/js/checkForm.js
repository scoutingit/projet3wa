$(function() {
    //vérification de formulaires
    $('#errorForm p').html('');
    
    $('#contactForm .sendForm').click(function() {
        var nbErreurs = 0;
        
        $('#contactForm input[required]').each(function() {
            var valeur = $(this).val();
            var valTrim = $.trim(valeur);
            $(this).val(valTrim);
            if(valTrim.length == 0) {
                nbErreurs++;
                $(this).css('border','1px solid red');
            }
            else{
                $(this).css('border','1px solid grey');
            }
        });
        
        $('#contactForm textarea[required]').each(function() {
            var valeur = $(this).val();
            var valTrim = $.trim(valeur);
            $(this).val(valTrim);
            if(valTrim.length == 0) {
                nbErreurs++;
                $(this).css('border','1px solid red');
            }
            else{
                $(this).css('border','1px solid grey');
            }
        });

        if(nbErreurs == 0) {
            $('#errorForm p').html('');
            //ajax envoi bdd
            var myName = $('#myName').val();
            var myLname = $('#myLname').val();
            var myMail = $('#myMail').val();
            var myMessage = $('#myMessage').val();
            var myDestination = $('#myDestination').val();
            $.ajax({
                 url : 'message/',
        		type : 'POST',
		    	data: { name : myName, lname : myLname, mail : myMail, message : myMessage, destination : myDestination},
            	dataType: 'json',
        		error : function(resultat, statut, erreur){
        			console.log('erreur ajax : '+resultat+"//"+statut+"//"+erreur);
        		}
            }).done(function(isDone){
                $('#errorForm p').html(isDone);
            });
        }
        else{
            $('#errorForm p').html('Oups, des champs sont vides');
        }
    });
});