# Woocommerce Currency Converter
<center><img src="https://user-images.githubusercontent.com/34242279/211606873-f2945960-acc8-45a0-b0ef-a662d3464e2c.png"/></center>
The driver code is mainly for large-scale E-commerce websites on Wordpress to update multiple product prices at once. Especially the driver code is being used for converting existing currency to a new currency by providing the conversion value or exchange rate manually. <br>
An example of usage purpose, suppose you want to change your Woocommerce currency but changing the currency doesn't make any effect on the product or changing the currency doesn't convert the price value as per the exchange rate between old currency and new currency. That's the point and this script was developed to solve this issue.
<br><br>
<b>How to use: </b>
<ol>
	<li>Go to file manager and open the path according to your domain <code>/wp-conetent/themes/theme-child</code></li>
	<li>Create a new <code>.php</code> file with any name. E.g. <code>template-woocommerce-currency-converter.php</code></li>
	<li>
		Copy and Paste the driver code from below or copy the code from the file added in the repository.
		<br>
		<sub><sup>[Note: Before saving the file make exchange rate is updated from the <code>$new_price</code>]</sup></sub>
	</li>
	<li>Go to <code>https://example.com/wp-admin</code></li>
	<li><code>Pages > Add new</code> Create a new page with any name. E.g. <code>Woo Currency Converter</code></li>
	<li>
		Select the template<code>Woocommerce Currency Converter</code> and publish the page <br>
		<img width="250px" src="https://user-images.githubusercontent.com/34242279/211214678-babf8e70-45c0-41af-bd21-afdf4857b042.png"/>
	</li>
	<li>The open the page and start updating the price.</li>
    <li>After complete the updating make sure Woocommerce transients are removed from <code>/wp-admin</code> > <code>WooCommerce</code> > <code>Status</code> > <code>Tools</code> > <code>Clear transients</code></li>
</ol>
<br>
<br>
<p align="center">Copy the below code <sub><sup>(edit if needed)</sup></sub></p>

<!-- language: php -->
```php
<?php 
    /*
    * Template Name: Woocommerce Currency Converter
    * Author: Abdullah Al Naiem
    * Date: January 07, 2023
    */
    global $paged;
    $posts_per_page = 50;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
    	'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'),
        'paged' => $paged
    );
    $products = new WP_Query( $args );
    $title = "Woocommerce - Currency Converter";
    $new_price = 7.53450;
    $update_action = (isset($_GET['update']) && $_GET['update'] == "true") ? true : false;
    $clear_wc_transient = (isset($_GET['clear']) && $_GET['clear'] == "wc_transients") ? true : false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }
        body {
            min-width: 1200px;
            font-size: 14px;
            padding: 0 20px;
        }
        header {
            position: sticky;
            top: 0;
            background-color: #f0f5ff;
            border-radius: 5px 5px 0 0;
            z-index: 9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            padding: 5px 20px;
            margin: 0 -20px;
        }
        header h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            margin-bottom: 15px;
            line-height: 1;
            text-shadow: -2px -2px 3px #ffffff, 2px 2px 3px #acbed8;
        }
        header ul {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            align-items: center;
        }
        header ul li {
            display: flex;
            font-weight: 500;
            align-items: center;
            line-height: 1;
        }
        header ul li+li {
            margin-left: 20px;
        }
        header .status,
        header .price span {
            margin-right: 5px;
        }
        .status {
            display: inline-flex;
            height: 20px;
            width: 20px;
            background-color: #000;
            border-radius: 50%;
            box-shadow: -2px -2px 3px #ffffff, 2px 2px 3px #acbed8;
            position: relative;
            margin: 0;
        }
        .status.update-success {
            background-color: #03d482;
        }
        .status.update-success::before {
            content: '';
            height: 4px;
            width: 10px;
            border: 3.4px solid #fff;
            border-top: 0;
            border-right: 0;
            transform: translate(-52%, -60%) rotate(-48deg);
            position: absolute;
            top: 50%;
            left: 50%;
        }
        .status.not-updated {
            background-color: #ff1037;
        }
        .status.update-not-required {
            background-color: #ffa800;
        }
        .navigation-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: absolute;
            right: 20px;
        }
        .navigation {
            padding: 0 10px 5px 0;
            text-align: right;
        }
        .navigation > nav span,
        .navigation > nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 18px;
            line-height: 16px;
            font-size: 12px;
            padding: 0 8px;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #aaf;
            color: #6e6eff;
            font-weight: 500;
            border-radius: 3px;
            transition: 0.3s;
        }
        .navigation > nav span.current {
            background-color: #03d482;
            color: #fff;
            border-color: #03d482;
        }
        .navigation > nav a:hover {
            background-color: #ffa800;
            color: #fff;
            border-color: #ffa800;
        }
        .navigation > nav a.prev.page-numbers:hover,
        .navigation > nav a.next.page-numbers:hover {
            background-color: #439cff;
            color: #fff;
            border-color: #439cff;
        }
        .navigation-actions > .actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding-left: 10px;
        }
        .navigation-actions button,
        .navigation-actions .button {
            width: 100%;
            height: 30px;
            line-height: 28px;
            border: 1px solid #aaaaff;
            font-weight: bold;
            padding: 0 13px;
            background-color: #fff;
            border-radius: 3px;
            cursor: pointer;
            transition: 0.3s;
        }
        .navigation-actions button:hover,
        .navigation-actions .button:hover {
            background-color: #8501c7;
            border-color: #8501c7;
            color: #fff!important;
        }
        header .clear-wc-transients {
            padding: 0 10px;
            display: none;
        }
        header .clear-wc-transients button {
            color: #ff1037;
            border-color: #ff1037!important;
            height: 20px;
            line-height: 18px;
        }
        header .clear-wc-transients button:hover {
            background-color: #ff1037;
        }
        .navigation-actions > .actions button.back {
            border-color: #ffa800;
            color: #ffa800;
        }
        .navigation-actions > .actions button.back:hover {
            background-color: #ffa800;
        }
        .navigation-actions > .actions button.update {
            border-color: #03d482;
            color: #03d482;
        }
        .navigation-actions > .actions button.update:hover {
            background-color: #03d482;
        }
        .navigation-actions > .actions button.update-next {
            border-color: #439cff;
            color: #439cff;
        }
        .navigation-actions > .actions button.update-next:hover {
            background-color: #439cff;
        }
        .navigation-actions .author {
            font-size: 13px;
            font-weight: 500;
            text-align: right;
            padding: 0 10px;
            line-height: 18px;
        }
        .navigation-actions .author a {
            font-weight: bold;
            color: #ff7f00;
            text-transform: unset;
        }
        .navigation-actions .author a.github {
            color: #00b06b;
            text-decoration: none;
        }
        content {}
        content .content-wrapper {}
        content .clear-wc-transients {
            text-align: center;
            color: #ff1037;
            font-size: 14px;
            font-weight: 500;
            padding: 20px;
            border: 2px dashed;
            margin: 5px auto;
        }
        table {
            width: 100%;
            border-spacing: 0;
            border: 1px solid #a4a4ff;
            border-right: 0;
            border-bottom: 0;
        }
        table thead th {
            background-color: #aaf;
            padding: 7px;
            border-bottom: 2px solid;
            border-color: #8501c7;
            position: sticky;
            top: 90px;
            z-index: 8;
        }
        table th,
        table td {
            text-align: center;
            vertical-align: middle;
            border: 1px solid #a4a4ff;
            border-top: 0;
            border-left: 0;
            padding: 5px 10px;
        }
        table thead th.title {
            min-width: 145px;
        }
        table thead th.price {
            width: 815px;
            max-width: 815px;
        }
        table tbody td.title,
        table tbody td.price {
            text-align: left;
        }
        table tbody .thumbnail img {}
        table tbody .prices {
            display: flex;
            gap: 5px;
        }
        .price .old-price,
        .price .new-price,
        .price .updated-price {
            background-color: #ff1037;
            color: #fff;
            font-weight: 500;
            display: inline-block;
            height: 19px;
            line-height: 19px;
            padding: 0 3px;
            border-radius: 3px;
            position: relative;
        }
        td.price .old-price,
        td.price .new-price,
        td.price .updated-price {
            height: 17px;
            line-height: 17px;
        }
        td.price .new-price {
            margin-left: 15px;
        }
        td.price .new-price::before {
            content: '';
            height: 5px;
            width: 5px;
            display: inline-block;
            position: absolute;
            background: #6e6eff;
            top: 6px;
            left: -10px;
            border-radius: 50%;
        }
        .price .updated-price {
            background-color: #03d482;
        }
        .price .new-price {
            background-color: #ffa800;
        }
        table tbody .prices .default-price,
        table tbody .price .variation-price {
            min-width: 265px;
            max-width: 265px;
            padding-bottom: 5px;
        }
        table tbody .prices > div > div {
            padding: 1px 4px;
        }
        table tbody .prices .default-price {
            background-color: #e1fff3;
        }
        table tbody .price .variation-price {
            background-color: #f3f3ff;
        }
        table tbody .price .prices {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            padding-bottom: 3px;
            font-size: 12px;
        }
        table tbody .price .prices span.price-heading {
            display: block;
            text-align: center;
            background-color: #7fefc2;
            font-weight: 600;
            padding: 3px;
        }
        table tbody .price .variation-price span.price-heading {
            background-color: #dedeff;
        }
        td .status {
            transform: scale(0.8);
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1><?php echo $title; ?></h1>
            <ul>
                <li><span class="status update-success"></span> Updated</li>
                <li><span class="status not-updated"></span> Not updated</li>
                <li><span class="status update-not-required"></span> Update not required</li>
                <li>
                    <ul class="price">
                        <li><span class="old-price">123</span> Old Price</li>
                        <li><span class="new-price">123</span> New Price</li>
                        <li><span class="updated-price">123</span> Updated Price</li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="navigation-actions">
            <div class="clear-wc-transients">
                <?php if(!$clear_wc_transient){ ?>
                    <button onclick="confirmClear('<?php echo the_permalink(). ($paged > 0) ? 'page/'.$paged : '' ?>?clear=wc_transients')">Clear Woocommerce Transients</button>
                <?php } ?>
            </div>
            <div>
                <div class="navigation">
                    <?php
                    // START - Pagination
                    add_filter( 'paginate_links', function( $link ){
                        return filter_input( INPUT_GET, 'update' ) ? remove_query_arg( 'update', $link ) : $link;
                    });
                    echo "<nav>".paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $products->max_num_pages
                    ))."</nav>";
                    // END- Pagination
                    ?>
                </div>
                <div class="author">
                    Script made by <a target="_blank" href="https://naiem.info">Naiem</a>
                    <br>
                    <a class="github" target="_blank" href="https://github.com/naiemofficial/Woocommerce-Currency-Converter/">View on Github</a>
                </div>
            </div>
            <div class="actions">
                <?php if($update_action || $clear_wc_transient){ ?>
                    <a href="<?php echo the_permalink(). ($paged > 0) ? "page/".$paged : "" ?>"><button class="back">Back to default</button></a>
                <?php } else if(!isset($_GET['update']) || (isset($_GET['update']) && $_GET['update'] != "true")){ ?>
                        <button class="update" onclick="confirmUpdate(<?php echo $paged; ?>, 'current', '<?php echo the_permalink(). ($paged > 0) ? 'page/'.$paged : '' ?>?update=true')">Update this page</button>
                <?php } ?>
                <?php if(!$clear_wc_transient){ ?>
                    <button class="update-next" onclick="confirmUpdate(<?php echo $paged; ?>, 'next', '<?php echo the_permalink(). ($paged == 0) ? 'page/'.($paged+2) : (($paged > 0) ? 'page/'.($paged+1) : '') ?>?update=true')">Update Next Page</button>
                <?php } ?>
            </div>
        </div>
    </header>
    <content>
        <?php if($clear_wc_transient){?>
            <div class="clear-wc-transients">/wp-admin > WooCommerce > Status > Tools > Clear transients</div>
        <?php } ?>
        <div class="content-wrapper">
            <table border="0">
                <thead>
                    <tr>
                        <th width="35px">SL</th>
                        <th width="70px">Image</th>
                        <th width="60px">ID</th>
                        <th class="title">Title</th>
                        <th class="price">Price(s)</th>
                        <th width="15px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        function validPrice($price){
                            return (strlen((string)(float)$price) > 0 && (float)$price > 0);
                        }
                        function displayPrice($status, $price, $updated_price){
                            echo "<span class='".($status == true ? 'updated-price' : 'old-price')."'>".$price."</span>". ($status != true ? "<span class='new-price'>".$updated_price."</span>" : "");
                        }
                        $sl = ($paged > 0) ? ((($paged*$posts_per_page)-$posts_per_page)+1) : 1;
                        if($products->have_posts()): while ( $products->have_posts() ) : $products->the_post(); 
                            global $product;
                            $updateSuccess = false;
                            $updateEligible = false;
                            $exchangeStatus = get_post_meta($product->id, 'currency_exchange', true);
                            $exchangeStatus = ($exchangeStatus == "" ? false : $exchangeStatus);
                            if(($update_action && $exchangeStatus != true) || !isset($_GET['update']) || (isset($_GET['update']) && $_GET['update'] != "true")){
                    ?>
                    <tr>
                        <th><?php echo $sl++; ?></th>
                        <td class="thumbnail">
                            <?php echo get_the_post_thumbnail($product->id, array( 60, 60) ); ?>
                        </td>
                        <td><?php echo $product->id; ?></td>
                        <td class="title"><?php echo get_the_title($product->id); ?></td>
                        <td class="price">
                            <?php
                                $_regular_price = get_post_meta($product->id,  '_regular_price', true);
                                $_sale_price = get_post_meta($product->id,  '_sale_price', true);
                                $_price = get_post_meta($product->id,  '_price', true);
                            ?>
                            <?php if(((float)$_regular_price > 0) || ((float)$_sale_price > 0) || ((float)$_price > 0)){ ?>
                                <div class="prices">
                                    <div class="default-price">
                                        <span class="price-heading">Default</span>
                                        <?php if(validPrice($_regular_price)){ 
                                            $updateEligible = true;
                                            $updated_price = (float)$_regular_price/$new_price;
                                            if($update_action == true){ 
                                                update_post_meta($product->id, '_regular_price', $updated_price); 
                                                $updateSuccess = true;
                                            }
                                        ?>
                                            <div><b>Regular:</b> <?php displayPrice($exchangeStatus, $_regular_price, $updated_price); ?></div>
                                        <?php } ?>
                                        <?php if(validPrice($_sale_price)){
                                            $updateEligible = true;
                                            $updated_price = (float)$_sale_price/$new_price;
                                            if($update_action == true){
                                                update_post_meta($product->id, '_sale_price', $updated_price);
                                                $updateSuccess = true;
                                            }
                                        ?>
                                            <div><b>Sale:</b> <?php displayPrice($exchangeStatus, $_sale_price, $updated_price); ?></div>
                                        <?php } ?>
                                        <?php if(validPrice($_price)){
                                            $updateEligible = true;
                                            $updated_price = (float)$_price/$new_price;
                                            if($update_action && $update_action){
                                                update_post_meta($product->id, '_price', $updated_price);
                                                $updateSuccess = true;
                                            }
                                        ?>
                                            <div><b>Price:</b> <?php displayPrice($exchangeStatus, $_price, $updated_price); ?></div>
                                        <?php } ?>
                                    </div>
                                    <?php
                                        foreach($product->get_children() as $variation){
                                            $_regular_price = get_post_meta($variation,  '_regular_price', true);
                                            $_sale_price = get_post_meta($variation,  '_sale_price', true);
                                            $_price = get_post_meta($variation,  '_price', true);
                                        ?>  
                                            <div class="variation-price">
                                                <span class="price-heading">Variation - <?php echo $variation; ?></span>
                                                <?php if(validPrice($_regular_price)){
                                                    $updateEligible = true;
                                                    $updated_price = (float)$_regular_price/$new_price;
                                                    if($update_action && $update_action){
                                                        update_post_meta($variation, '_regular_price', $updated_price);
                                                        $updateSuccess = true;
                                                    }
                                                ?>
                                                    <div><b>Regular:</b> <?php displayPrice($exchangeStatus, $_regular_price, $updated_price); ?></div>
                                                <?php } ?>
                                                <?php if(validPrice($_sale_price)){
                                                    $updateEligible = true;
                                                    $updated_price = (float)$_sale_price/$new_price;
                                                    if($update_action && $update_action){
                                                        update_post_meta($variation, '_sale_price', $updated_price);
                                                        $updateSuccess = true;
                                                    }
                                                ?>
                                                    <div><b>Sale:</b> <?php displayPrice($exchangeStatus, $_sale_price, $updated_price); ?></div>
                                                <?php } ?>
                                                <?php if(validPrice($_price)){
                                                    $updateEligible = true;
                                                    $updated_price = (float)$_price/$new_price;
                                                    if($update_action && $update_action){
                                                        update_post_meta($variation, '_price', $updated_price);
                                                        $updateSuccess = true;
                                                    }
                                                ?>
                                                    <div><b>Price:</b> <?php displayPrice($exchangeStatus, $_price, $updated_price); ?></div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                </div>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                                if(!$exchangeStatus && $updateEligible && $update_action && $updateSuccess){
                                    update_post_meta($product->id, 'currency_exchange', true);
                                    echo  "<span class='status update-success' title='Updated'></span>" ;
                                } else if(!$exchangeStatus && $updateEligible) {
                                    echo "<span class='status not-updated' title='Not updated'></span>";
                                } else if($exchangeStatus){
                                    echo "<span class='status update-success' title='Already Updated'></span>";
                                } else {
                                    echo "<span class='status update-not-required' title='Update not required'></span>";
                                }
                            ?>
                        </td>
                    </tr>
                    <?php } endwhile; 
                        wp_reset_postdata();
                    endif; ?>
                </tbody>
            </table>
        </div>
    </content>
    <script>
        function confirmClear(URL) {
            if(confirm("Are you sure to clear/delete Woocommerce transients. This action can't be undone, make sure you've taken a backup before confirm the action.")){
                window.location = URL;  
            }
        }
        function confirmUpdate(page, pageOf, URL) {
            if(pageOf == "next"){
                page = (page == 0) ? 2 : page+1;
            }
            if(confirm("Are you sure to update " + (pageOf == "current" ? "this" : (pageOf == "next" ? "the next" : pageOf)) + " page! [PN-"+(page == 0 ? 1 : page)+"]")){
                window.location = URL;  
            }
        }
    </script>
</body>
</html>
```