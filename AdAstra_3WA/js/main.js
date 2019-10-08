$(function() {
    $('#mailTo').hide();
    $('#errorForm p').html('');
    //afficher messagges
    function ShowMessage(){
        $.ajax({
            url : 'message/',
    		type : 'POST',
	    	data: { selectAll : true},
        	dataType: 'json',
    		error : function(resultat, statut, erreur){
    			console.log('erreur ajax : '+resultat+"//"+statut+"//"+erreur);
    		}
        }).done(function(isDone){
            $('#allMessage div').remove();
            for(var i = 0;i<isDone.length;i++){
                var answer = "";
                isDone[i].contactState == 0?answer="En attente de réponse.":answer="Réponse envoyée.";
                $('#allMessage').append('<div class="message">'
                    +'<p class="messDate">Message de : '+isDone[i].contactLname+' '+isDone[i].contactName
                    +'<br>Envoyé le : '+isDone[i].contactDate+'</p>'
                    +'<br>Statut : '+answer+'</p>'
                    +'<p class="messMessage">Message : '+isDone[i].contactMessage+'</p>'
                    +'<p class="messEdit" data-myid="'+isDone[i].contactId+'" data-name="'+isDone[i].contactLname+' '+isDone[i].contactName+'" data-mail="'+isDone[i].contactMail+'"><i class="fas fa-pen-square"></i></p>'
                    +'<p class="messDel" data-myid="'+isDone[i].contactId+'"><i class="fas fa-minus-square"></i></p>'
                    +'<div id="hideId'+isDone[i].contactId+'" class="answerMail">'
                        +'<p id="userId" data-userid="'+isDone[i].userId+'">Réponse de : '+isDone[i].userName+'</p>'
                        +'<p>Le : '+isDone[i].mailDate+'</p>'
                        +'<p>Message : '+isDone[i].mailMessage+'</p>'
                    +'</div>'
                +'</div>');
                //cacher la réponse si elle est null
                if(isDone[i].contactState == 0){
                    $('#hideId'+isDone[i].contactId).hide();
                }
            }
        });
    }
    
    //change le css du menu en fonction de la page courante
    if(currentPage == "suborbital"){
         $('#menuh ul li:nth-child(1)').addClass('boldMenu');
    }
    else if(currentPage == "lune"){
         $('#menuh ul li:nth-child(2)').addClass('boldMenu');
    }
    else if(currentPage == "mars"){
         $('#menuh ul li:nth-child(3)').addClass('boldMenu');
    }
    else if(currentPage == "bkoffice"){
        ShowMessage();
    }
    
    //connexion admin
    $('#admin #sendForm').click(function(){
        var userLog = $('#userLog').val();
        var userPasse = $('#userPass').val();
        $.ajax({
            url : 'bkoffice/',
    		type : 'POST',
	    	data: { name : userLog, passe : userPasse},
        	dataType: 'json',
    		error : function(resultat, statut, erreur){
    			console.log('erreur ajax : '+resultat+"//"+statut+"//"+erreur);
    		}
        }).done(function(isDone){
            if(isDone != "done"){  
                $('#errorForm p').html(isDone);
            }
            else{
                window.location.href = 'bkoffice/';
            }
        });
    });
    
    //reponse message
    $('#allMessage').on('click','.messEdit',function(){
        $('#mailTo span').html($(this).data('name'));
        $('#mailToMail').val($(this).data('mail'));
        $('#mailToId').val($(this).data('myid'));
        $('#mailTo').fadeIn();
    });
    
    //suppression message
    $('#allMessage').on('click','.messDel',function(){
        var myId = $(this).data('myid');
        $.ajax({
            url : 'message/',
    		type : 'POST',
	    	data: { del : true, delId : myId},
        	dataType: 'json',
    		error : function(resultat, statut, erreur){
    			console.log('erreur ajax : '+resultat+"//"+statut+"//"+erreur);
    		}
        }).done(function(isDone){
            if(isDone != "done"){
                $('#errorForm p').html(isDone);
            }
            else{
                ShowMessage();
            }
        });
    });
    
    //envoi réponse
    $('#mailTo .sendForm').click(function(){
        var myMail = $('#mailToMail').val();
        var myMessage = $('#mailMessage').val();
        var myId = $('#mailToId').val();
        var myuserId = $('#userId').data('userid');
        $.ajax({
            url : 'message/',
    		type : 'POST',
	    	data: { sendMail : true , mail : myMail, message : myMessage, messId : myId, userId : myuserId},
        	dataType: 'json',
    		error : function(resultat, statut, erreur){
    			console.log('erreur ajax : '+resultat+"//"+statut+"//"+erreur);
    		}
        }).done(function(isDone){
            if(isDone == "done"){
                ShowMessage();
                $('#errorForm p').html("<span>Mail envoyé!</span>");
            }
        });
    });
    
    //fermer formulaire réponse + reset
    $('#mailTo #closeForm').click(function(){
        $('#mailTo span').html("");
        $('#mailToMail').val("");
        $('#mailToId').val("");
        $('#mailMessage').val("");
        $('#errorForm p').html("");
        $('#mailTo').fadeOut("fast");
    });
});
