$(document).ready(function() {
	$('#pseudo').keyup(function() {
		var pseudo = $('#pseudo').val();

		if(pseudo!="") {
			$.post('php/pseudo.php',{pseudo:pseudo}, function(data){
				$('.feedback').text(data);
			});
		} else {
			$('.feedback').text("Pseudo manquant");
		}
	});
});

(function(){

	$(window).on('resize', function(){
		resizeHome();
	})

	resizeHome();

	$('.dropdown-toggle').dropdown();

	// Tabs fiche d'un jeu

	$(function () {
	    $('#myTab a:first').tab('show');
	});

	// Recherche rapide d'un jeu header

	shouldSubmit = false;
	$(".quick-search form").submit(function(e) {

		form = $(this);
		input = form.find("#search");
		submit = form.find("#submit");

		if(shouldSubmit == true && !input.val()){
			form.removeClass('visible');
			return false;
		}

		if(shouldSubmit != true){
			shouldSubmit = true;
			e.preventDefault();
		}
		
		form.addClass('visible');
		setTimeout(function(){
			input.focus();
		}, 300);
		
		input.blur(function() {
			if(!input.val()) {
				form.removeClass('visible');
				setTimeout(function(){
					shouldSubmit = false;
				}, 300);
			};
		});
	});

	// Affichage image avant envoi formulaire

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	            
	        reader.onload = function (e) {
	            $('#apercu').attr('src', e.target.result);
	        };
	            
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	    
	$(".avatar").change(function(){
	    readURL(this);
	});

	// Accueil

	function resizeHome(){
		wh = $(window).innerHeight();
		nav = $('header').outerHeight();
		bgElem = $('.bgElem');

		bgElem.height(wh-nav);
	}

	$(document).on('scroll', function(){
		if($('body').attr('id') == 'fiche'){
			ficheScroll();
		}
	})

	// Colonne fixe fiche d'un jeu

	function ficheScroll(){
		sidebar = $('.sidebar ul');
		value = $('body').scrollTop();
		visuFiche = $('.visuelFiche').outerHeight();
		if(value > visuFiche){
			sidebar.css({'position': 'fixed', 'top': 169});
		} 
		else{
			sidebar.css({'position': 'static'});
		}

		wh = $(window).innerHeight();
		if (wh < 600) {
			sidebar.css({'position': 'static'});
		}
	}

	// Personnalisation des select

	sp = $('.selectpicker');
	if (sp.length > 0) {
		sp.selectpicker();
	}

	// Confirmation avant suppression

	$('.securite').on('click', function(event){
		event.preventDefault();
		var confirmation = confirm('Voulez-vous supprimer cette fiche définitivement ?');
		if (confirmation == true) {
			window.location.href = $(this).prop('href');
		}
	});
	
})();



	function positionPopup(){

		var w = $(window).width(),
		    h = $(window).height(),
		    popup = $('.popup'),
		    popW = popup.outerWidth(),
		    popH = popup.outerHeight();

		popup.css({
		    top: h/2 - popH/2,
		    left: w/2 - popW/2
		}).show();

		$('.overlay').fadeIn('slow');

		fermerPopup();
	}

	function fermerPopup(){
		$('button, .popup').click(function(){
		    $('.popup').remove();
		    $('.overlay').remove();
		});
	}

//positionPopup();
		    	
