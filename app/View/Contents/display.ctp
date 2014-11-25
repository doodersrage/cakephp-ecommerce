<div class="page-head">
    <h1><?php echo h($content['Content']['header']); ?></h1>
</div>

<div class="bread-crumbs">
    <a href="#">Home</a>
</div>

<div class="row marketing">
    <?php if($content['Content']['pageImage']){ ?>
    <div class="col-lg-3 prod-image">
        <?php echo $this->Html->image('/app/webroot/'.$content['Content']['pageImage']); ?>
    </div>
    <div class="col-lg-9">
        <?php echo $content['Content']['content']; ?>
    </div>
    <?php } else { ?>
    <div class="col-lg-12">
        <?php echo $content['Content']['content']; ?>
    </div>
    <?php } ?>

            <?php
            // print products listing if products variable is set
            if(isset($products)){

                echo '<div class="row">
                        <div class="col-lg-12">';

                // convert list type data
                $productTypeData = unserialize($productType['ProductType']['attributes']);

                // print products listing headers
                echo '<table>
                            <tr>
                                <th>Item Number</th>';
                    $diplayColumns = array();
                    $bubbleColumns = array();
                    foreach($productTypeData[0] as $productAttribute){
                        if(!in_array($productAttribute, $productTypeData[1], true)){
                            $diplayColumns[] = $productAttribute;
                            echo '<th>'.$attributes[$productAttribute].'</th>';
                        } else {
                            $bubbleColumns[] = $productAttribute;
                        }
                    }

                    // add static product values
                    echo '<th>Quantity</th>
                        <th>Price Each</th>
                        <th class="lw">More Info</th>
                        <th class="lw">Qty</th>
                        <th class="lw">Total</th>';
                echo '      </tr>';

                // print all product data
                foreach($products as $product){
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
                    echo '<td>'.$product['Product']['quantity'].'</td>';
                    echo '<td class="cost-clm">$'.$product['Product']['price'].'</td>';
                    // generate content bubble
                    $bubbleTxt = '';
                    foreach($bubbleColumns as $bubbleColumn){
                        if(isset($productAttributes[$product['Product']['itemNumber']][$bubbleColumn])){
                            $bubbleTxt .= '<b>'.$attributes[$bubbleColumn].'</b> '.$productAttributes[$product['Product']['itemNumber']][$bubbleColumn]['ProductAttribute']['content'].'<br>';
                        }

                    }
                    echo '<td>'.(!empty($bubbleTxt) ? '<a href="#" data-toggle="popover" data-content="'.$bubbleTxt.'" >hover</a>' : '&nbsp;').'</td>';
                    echo '<td class="qty-clm"><input type="number" name="qty[]"></td>';
                    echo '<td class="ttl-clm"></td>';
                    echo '</tr>';
                }

                echo '</table>';

                echo '</div>
                    <div class="col-lg-offset-10 col-lg-2">
                        <p>Total: <span id="total"></span></p>
                        <button type="submit">Check Out</button>
                    </div>';
            }

            ?>

    </div>

</div>