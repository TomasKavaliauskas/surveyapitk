$ = jQuery;

var k = -50;

$(document).ready(function() {
	
	$('#add-question').on('click', function(e) {
		e.preventDefault();
		
		if(k == -50) {
			
			if(!$('#create-button').length) {
				$('#buttons').append('<button class="btn btn-primary" id="create-button" type="submit">Kurti apklausą</button>');
			}
			
		}
		$('#questions-block').append('<div id="question_'+k+'" style="margin-bottom: 50px"><div class="form-group"><input placeholder="Klausimas" type="text" class="form-control" name="question_'+k+'_title" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 1" class="form-control" type="text" name="question_'+k+'_option_1" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 2" class="form-control" type="text" name="question_'+k+'_option_2" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 3" class="form-control" type="text" name="question_'+k+'_option_3" value=""/></div><div class="form-group"><input placeholder="Pasirinkimas 4" class="form-control" type="text" name="question_'+k+'_option_4" value=""/></div><button class="btn btn-primary delete-question" data-question="'+k+'">Ištrinti klausimą</button></div>');
		k++;
		bindDelete();
	});
	
});

function bindDelete() {
	
	$('.delete-question').on('click', function(e) {
		
		e.preventDefault();
		if($('#question_'+$(this).attr('data-question')).remove()) {
			k--;
			if(isEmpty($('#questions-block'))) {
				$("#create-button").remove();
			}
		}
		
	});
	
}

  function isEmpty( el ){
      return !$.trim(el.html())
  }