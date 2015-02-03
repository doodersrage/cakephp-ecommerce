<div class="page-head">
    <h1><?php echo h($content['Content']['header']); ?></h1>
</div>

<div class="bread-crumbs">
    <a href="#">Home</a>
</div>
<?php
// flash warning message
echo $this->Session->flash();
?>

<div class="row marketing">
    <div class="row">
		<?php if($content['Content']['pageImage']){ ?>
        <div class="col-lg-3 col-md-3 prod-image">
            <?php echo $this->Html->image('/app/webroot/'.$content['Content']['pageImage']); ?>
        </div>
        <div class="col-lg-9 col-md-9">
            <?php echo $content['Content']['content']; ?>
        </div>
        <?php } else { ?>
        <div class="col-lg-12">
            <?php echo $content['Content']['content']; ?>
        </div>
        <?php } ?>
    </div>

            <?php
            // print products listing if products variable is set
            if(isset($products)){

                echo '<div class="row">
                        <div class="col-lg-12">';

                // convert list type data
                $productTypeData = unserialize($productType['ProductType']['attributes']);
				
				// store products data for JSON access
				$jsonProdData = array();
				
				// gather tiered pricing columns
				$tieredPricing = unserialize($productType['ProductType']['tieredPricing']);
				if(empty($tieredPricing)) {
					$rowspan = '';
				} else {
					$rowspan = ' rowspan="2"';
				}

                // print products listing headers
                echo '<table>
                            <tr>
                                <th'.$rowspan.'>Item Number</th>';
                    $diplayColumns = array();
                    $bubbleColumns = array();
					// check for bubble array and reset if not found
					if(!is_array($productTypeData[1])){
						$productTypeData[1] = array('No');
					}
                    foreach($productTypeData[0] as $productAttribute){
                        if(!in_array($productAttribute, $productTypeData[1], true) && array_key_exists($productAttribute ,$attributes)){
                            $diplayColumns[] = $productAttribute;
                            echo '<th'.$rowspan.'>'.$attributes[$productAttribute].'</th>';
                        }
                    }

                    // add static product values
					if($productType['ProductType']['enforceQty'] == true){
						echo '<th'.$rowspan.'>Quantity</th>';
					}
					
					// print tiered pricing headers
					if(!empty($tieredPricing)){
						echo '<th colspan="'.count($tieredPricing).'" style="text-align:center">Volume Pricing</th>';
					}
					
                    echo '<th'.$rowspan.'>Price '.(!empty($productType['ProductType']['dimensionMeasurement']) ? 'per'.(!empty($productType['ProductType']['dimensionType']) ? ' '.$productType['ProductType']['dimensionType'].' ' : ' ').($productType['ProductType']['dimensionMeasurement'] == 'in' ? 'ft' : $productType['ProductType']['dimensionMeasurement']) : 'Each').'</th>';
					if($productTypeData[1][0] != 'No'){
						echo '<th'.$rowspan.' class="lw">More Info</th>';
					}
					// gather max min quantity and determin full size options
					$minQtyCnt = 0;
					$fullSize = 0;
					foreach($products as $product){
						$minQtyCnt += $product['Product']['minQty'];
						if($product['Product']['fullLength'] > 0 || $product['Product']['fullLength']){
							$fullSize = 1;
						}
					}
					
					// print product dimension entry fields if enabled
					if($productType['ProductType']['custDimension'] == 1){
						$domensionType = $productType['ProductType']['dimensionType'];
						if($fullSize === 1){
							echo '<th'.$rowspan.' class="lw">Full Size</th>';
						}
						echo '<th'.$rowspan.' class="lw">Length'.(empty($productType['ProductType']['dimensionMeasurement']) ? ' (ft)' : ' ('.$productType['ProductType']['dimensionMeasurement'].')').'</th>';
						if(empty($domensionType) || $domensionType == 'square'){
							echo '<th'.$rowspan.' class="lw">Width'.(empty($productType['ProductType']['dimensionMeasurement']) ? ' (ft)' : ' ('.$productType['ProductType']['dimensionMeasurement'].')').'</th>';
						}
					}
					// display min quantity if found
					if($minQtyCnt > 0){
						echo	'<th'.$rowspan.' class="lw">Min<br> QTY</th>';
					}
					
					echo '<th'.$rowspan.' class="lw">Qty</th>';
					
                    echo	'<th'.$rowspan.' class="lw">Total</th>';
                	echo	'</tr>';
					
					// print tiered pricing headers
					if(!empty($tieredPricing)){
						echo '<tr>';
						foreach($tieredPricing as $tprice){
							echo '<th>'.$tprice[1].'</th>';
						}
						echo '</tr>';
					}

                // print all product data
                foreach($products as $product){
					
					$prodTieredPrices = unserialize($product['Product']['tieredPricing']);
					
					// gather product tiered pricing
					$prodTieredPriceData = array();
					if(!empty($tieredPricing)){
						foreach($tieredPricing as $tpidx => $tprice){
							if(isset($prodTieredPrices[$tprice[0]])){
								$prodTieredPriceData[$tprice[0]] = $prodTieredPrices[$tprice[0]];
							} else {
								$prodTieredPriceData[$tprice[0]] = 0;
							}
						}
					}

					// store product for json object retrieval
					$jsonProdData[$product['Product']['itemNumber']] = array(
												'price'=>$product['Product']['price'],
												'enforceQty'=>$productType['ProductType']['enforceQty'],
												'quantity'=>(!empty($product['Product']['quantity']) ? $product['Product']['quantity'] : 0),
												'minQty'=>(!empty($product['Product']['minQty']) ? $product['Product']['minQty'] : 0),
												'fullLength'=>$product['Product']['fullLength'],
												'fullWidth'=>$product['Product']['fullWidth'],
												'custDimension'=>$productType['ProductType']['custDimension'],
												'dimensionType'=>$productType['ProductType']['dimensionType'],
												'dimensionMeasurement'=>$productType['ProductType']['dimensionMeasurement'],
												'tieredPrice'=>$prodTieredPriceData,
												);
					
                    echo '<tr>';
                    echo '<td>'.$product['Product']['itemNumber'].'</td>';
                    // print product attributes
                    foreach($diplayColumns as $diplayColumn){
                        if(isset($productAttributes[$product['Product']['itemNumber']][$diplayColumn])){
                            echo '<td>'.$productAttributes[$product['Product']['itemNumber']][$diplayColumn]['ProductAttribute']['content'].'</td>';
                        } else {
                            echo '<td>&nbsp;</td>';
                        }
                    }
					
					// print qty if enforced
					if($productType['ProductType']['enforceQty'] == true){
						echo '<td>'.$product['Product']['quantity'].'</td>';
					}
					
					// print product tiered pricing, if assigned
					if(!empty($tieredPricing)){
						foreach($tieredPricing  as $tpidx => $tpval){
							if(isset($prodTieredPriceData[$tpval[0]])){
								if($prodTieredPriceData[$tpval[0]] > 0){
									echo '<td>$'.number_format($prodTieredPriceData[$tpval[0]],2).'</td>';
								} else {
									echo '<td>&nbsp;</td>';
								}
							} else {
								echo '<td>&nbsp;</td>';
							}
							
						}
					}
					
                    echo '<td class="cost-clm">$'.$product['Product']['price'].'</td>';
                    
					// generate content bubble
                    $bubbleTxt = '';
					// print more info bubbles
					if($productTypeData[1][0] != 'No'){
						foreach($productTypeData[1] as $bubbleColumn){
							if(isset($productAttributes[$product['Product']['itemNumber']][$bubbleColumn]) && array_key_exists($bubbleColumn ,$attributes)){
								$bubbleTxt .= '<b>'.$attributes[$bubbleColumn].'</b> '.$productAttributes[$product['Product']['itemNumber']][$bubbleColumn]['ProductAttribute']['content'].'<br>';
							}
	
						}
					}
                    if(!empty($bubbleTxt)) echo '<td>'.(!empty($bubbleTxt) ? '<a href="#" data-toggle="popover" data-content="'.$bubbleTxt.'" >'.$this->Html->image('/app/webroot/img/question_mark.png').'</a>' : '&nbsp;').'</td>';
					if($productType['ProductType']['custDimension'] == 1){
						if($fullSize === 1){
							if($product['Product']['fullLength'] > 0 || $product['Product']['fullWidth']){
								echo '<td class="length-clm"><input type="checkbox" class="fullSizeBtn" name="fullSize['.$product['Product']['itemNumber'].']"></td>';
							} else {
								echo '<td class="length-clm">&nbsp;</td>';
							}
						}
						echo '<td class="length-clm"><input type="number" name="length['.$product['Product']['itemNumber'].']" value="0"></td>';
						if(empty($domensionType) || $domensionType == 'square'){
							echo '<td class="width-clm"><input type="number" name="width['.$product['Product']['itemNumber'].']" value="0"></td>';
						}
					}
					// print minimum qty
					if($minQtyCnt > 0){
						echo '<td>'.$product['Product']['minQty'].'</td>';
					}
					// user entry product qty field
                    echo '<td class="qty-clm"><input type="number" name="qty['.$product['Product']['itemNumber'].']" value="0"></td>';
					// item price total
                    echo '<td class="ttl-clm"></td>';
                    echo '</tr>';
                }

                echo '</table>';
				?>
                	<p>
				<?php
                echo $this->Paginator->counter(array(
                'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
                ?>	</p>
                <ul class="pager">
                <?php
                    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => ''));
                    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                ?>
                </ul>
                <?php
				// print page related JS
				echo '<script>
						var prodData = '.json_encode($jsonProdData).';
					</script>';
				
                echo '</div>
                    <div class="col-lg-offset-10 col-lg-2 col-md-offset-10 col-md-2">
                        <form method="post" action="/cart">
						<p>Sub-Total: <span id="total"></span></p>
                        <button type="submit">View Cart</button>
						</form>
                    </div>';
					?>
                    <script>
					'use strict';
					
					var prodDataJSON, currentQtys = {};
					
					// update order total display
					var updatePgTotal = function(){
						var orderTotal = 0;
					
						// gather order totals
						$('.ttl-clm').each(function(index){
							var itmTotl = Number($('.ttl-clm').eq(index).html().trim().replace(/[^0-9\.]+/g,''));
					
							orderTotal += itmTotl;
						});
					
						$('#total').html('$'+orderTotal.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
					
					};
					
					// gather product pricing based on applied pricing features
					var gatherPrice = function(idx, itmNmbr, qty){
						// loop through quantity key values to determine possible pricing options
						var i = 0, setPrice = prodDataJSON[itmNmbr].price;
						for (var key in prodDataJSON[itmNmbr].tieredPrice) {
							if (prodDataJSON[itmNmbr].tieredPrice.hasOwnProperty(key)) {
								// return if initial value is 0
								if(i == 0 && prodDataJSON[itmNmbr].tieredPrice[key] == 0){
									return setPrice;
								}
								// update user price based on entered qty value
								if(qty >= key){
									setPrice = prodDataJSON[itmNmbr].tieredPrice[key];
								}
								++i;
							}
						}
						
						return setPrice;
					}
					
					// update product pricing based on quality
					var updateProdQty = function(idx, itmNmbr){
					
						// gather pricing data
						var qty = parseInt($('.qty-clm input[type="number"]').eq(idx).val());
						
						// enforce user max quantity if enabled
						if(prodDataJSON[itmNmbr].enforceQty === true && qty > prodDataJSON[itmNmbr].quantity){
							$('.qty-clm input[type="number"]').eq(idx).val(prodDataJSON[itmNmbr].quantity);
						}
						// retrieve prod price
						var price = gatherPrice(idx, itmNmbr, qty);
						
						// determine if price needs to be adjusted based on assigned product measurement unit
						if(prodDataJSON[itmNmbr].dimensionMeasurement === 'in' && prodDataJSON[itmNmbr].dimensionType === 'square'){
							price /= 144;
						} else if(prodDataJSON[itmNmbr].dimensionMeasurement === 'in' && prodDataJSON[itmNmbr].dimensionType === 'linear'){
							price /= 12;
						}
					
						// check for min selected product quantity	
						if(qty < parseFloat(prodDataJSON[itmNmbr].minQty)){
							if(currentQtys[itmNmbr].qty > qty || qty === 0){
								qty = 0;
								$('.qty-clm input[type="number"]').eq(idx).val(qty);
							} else {
								qty = prodDataJSON[itmNmbr].minQty;
								$('.qty-clm input[type="number"]').eq(idx).val(qty);
							};
						};
							
						// store selected qty vals
						currentQtys[itmNmbr].qty = qty;
						
						// check for length and width values of selected product
						if($('input[name="length['+itmNmbr+']"]').length){
							if($('input[name="length['+itmNmbr+']"]').val() > 0){
								var length = $('input[name="length['+itmNmbr+']"]').val();
							} else {
								var length = 0;
							};
							$('input[name="length['+itmNmbr+']"]').val(length);
							var dimMulti = length;
							currentQtys[itmNmbr].length = length;
							if($('input[name="width['+itmNmbr+']"]').length){
								if($('input[name="width['+itmNmbr+']"]').val() > 0){
									var width = $('input[name="width['+itmNmbr+']"]').val();
								} else {
									var width = 0;
								};
								$('input[name="width['+itmNmbr+']"]').val(width);
								currentQtys[itmNmbr].width = width;
								var dimMulti = width * length;
							}
						} else {
							var dimMulti = 1;
						};
						
						// assign product pricing
						var total = price * dimMulti * qty;
						total = total.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
						
						// update pricing in page
						$('.ttl-clm').eq(idx).html('$'+total);
						
						// save details to session variable via JSON AJAX
						$.ajax({
						  url: '/cart/add',
						  type: 'POST',
						  data: {cart: currentQtys}
					//	  success: function(data) {
					//		  console.log(data);
					//	  }
						});
					
						// update order total
						updatePgTotal();
					};
					
					// gather product item number
					var prodItemNum = function(idx){
						var name = $('.qty-clm input[type="number"]').eq(idx).attr('name');
						return name.match(/^qty\[(.*)\]/i)[1];
					};
					
					// set field defaults
					var prodDefaults = function(cartData){
							
						// wakl through each product input
						$('.qty-clm input[type="number"]').each(function(index){
							
							// gather selected item number
							var itmNmbr = prodItemNum(index);
							
							if($('.qty-clm input[type="number"]').eq(index).length){
								// check for existing cart data
								if(cartData && cartData[itmNmbr]){
									$('.qty-clm input[type="number"]').eq(index).val(cartData[itmNmbr].qty);
								} else {
									$('.qty-clm input[type="number"]').eq(index).val(0);
								}
							};
								
							// handle size value changes
							var dimEnabled = 0;
							if($('input[name="length['+itmNmbr+']"]').length){
								// load cart values
								if(cartData && cartData[itmNmbr]){
									$('input[name="length['+itmNmbr+']"]').val(cartData[itmNmbr].length);
								}
								$('input[name="length['+itmNmbr+']"]').change(function(){
									// enforce full length values
									var prodFullLength = Number(prodDataJSON[itmNmbr].fullLength);
									if(Number(prodFullLength) > 0){
										if(Number($(this).val()) > prodFullLength){
											$(this).val(prodFullLength);
										}
									}
									
									// update displayed price
									updateProdQty(index,itmNmbr);
								});
								if($('input[name="width['+itmNmbr+']"]').length){
									// load cart values
									if(cartData && cartData[itmNmbr]){
										$('input[name="width['+itmNmbr+']"]').val(cartData[itmNmbr].width);
									}
									$('input[name="width['+itmNmbr+']"]').change(function(){
										// enforce full width values
										var prodFullWidth = Number(prodDataJSON[itmNmbr].fullWidth);
										if(prodFullWidth > 0){
											if(Number($(this).val()) > prodFullWidth){
												$(this).val(prodFullWidth);
											}
										}
										
										// update displayed price
										updateProdQty(index,itmNmbr);
									});
								}
								dimEnabled = 1;
							};
							
							// store default qty vals
							currentQtys[itmNmbr] = {'qty':0,'dimEnabled':dimEnabled,'length':0,'width':0,'url':document.URL};
							
							updateProdQty(index,itmNmbr);
						});
					};
					
					$(function(){
						
						prodDataJSON = prodData;
					
						// enabled popovers
						$('[data-toggle="popover"]').popover({
							trigger: 'hover',
							'placement': 'top',
							html: true
						});
					
						// set product defaults on page load
						$.getJSON("/cart/get",function(data){
							prodDefaults(data);
						});
					
						// handle product pricing
						$('.qty-clm input[type="number"]').change(function(){
					
							// gather selected index
							var idx = $('.qty-clm input[type="number"]').index(this);
							
							// gather selected item number
							var itmNmbr = prodItemNum(idx);
									
							// update pricing
							updateProdQty(idx,itmNmbr);
							
						});
						
						// set dimension values to full on full size button click
						$('.fullSizeBtn').click(function(){
							if($(this).is(':checked')){
								var name = $(this).attr('name');
								var itmNmbr = name.match(/^fullSize\[(.*)\]/i)[1];
								$('input[name="length['+itmNmbr+']"]').val(prodDataJSON[itmNmbr].fullLength);
								if($('input[name="width['+itmNmbr+']"]').length){
									$('input[name="width['+itmNmbr+']"]').val(prodDataJSON[itmNmbr].fullWidth);
								}
							}
						});
							
					});
					</script>
                    <?php
            }
			
			// print contact form if enabled
			if($content['Content']['contactForm'] == 1){
				if(!isset($this->request->data['Contact']['name']) && !isset($this->request->data['Contact']['email']) && !isset($this->request->data['Contact']['message'])){
					echo $this->Form->create('Contact', array('type'=>'file')); ?>
                    <fieldset>
                        <legend><?php echo __('Contact Custom Glass & Silicon'); ?></legend>
                    <?php
                        echo $this->Form->input('name', array('required'=>'required', 'label'=>'Name: *', 'class'=>'form-control',));
                        echo $this->Form->input('email', array('required'=>'required', 'label'=>'Email: *', 'class'=>'form-control',));
                        echo $this->Form->label('Message: *');
                        echo $this->Form->textarea('message', array('required'=>'required', 'class'=>'form-control', 'rows' => '5', 'cols' => '5'));
                        ?>
                        </fieldset><br>
                    <?php 
                    echo $this->Form->submit('Submit',array(
                                                  'class' => 'btn btn-lg btn-primary btn-block',
                                                  'div' => false));
                    echo $this->Form->end();
				} else {
					echo '<p style="text-align:center"><b>Thanks for contacting us! We will get back to you shortly!</b></p>';
				}
			}
            ?>

    </div>

</div>