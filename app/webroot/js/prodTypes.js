// load existing price sets
var addTierRow = function(defQuant, defHeader){
	$('#tieredPricing > tbody')
		.append($('<tr>')
			.append($('<td>')
				.append($('<input>')
					.attr('name', 'maxValue[]')
					.attr('type', 'text')
					.val(defQuant)
				)
			)
			.append($('<td>')
				.append($('<input>')
					.attr('name', 'clmText[]')
					.attr('type', 'text')
					.val(defHeader)
				)
			)
			.append($('<td style="text-align:center">')
				.append($('<a href="#" class="glyphicon-minus remove-price">&nbsp;</a>')
				)
			)
	);
}

var loadExistingPrices = function(){
	var priceCnt = tieredPrices.length;
	for(var i = 0; i < priceCnt; ++i){
		addTierRow(tieredPrices[i][0], tieredPrices[i][1]);
	}
}

$(function(){
	
	// load existing price sets
	loadExistingPrices()
	
	// add tiered price entry
	$('.add-price').click(function(e){
		e.preventDefault();
		addTierRow('','');
		return false; 
	});
	
	// remove tired price entry
	$(document.body).on('click', '.remove-price', function(e){
		e.preventDefault();
		
		var idx = $('.remove-price').index(this)+1;
		
		$('#tieredPricing tr').eq(idx).remove();
		
		return false; 
	});
});