<?php 
	/*
     * Template Name: Woocommerce Currency Converter
     * Author: Abdullah Al Naiem
     * Date: January 07, 2023
    */
    // update_post_meta(999, 'currency_exchange', true);
    global $paged;
    $posts_per_page = 50;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged
    );
    $products = new WP_Query( $args );
    $title = "Woocommerce - Currency Converter";
    $new_price = 7.53450;
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
        .status.updated,
        .status.already-updated {
            background-color: #03d482;
        }
        .status.already-updated::before {
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
            align-items: center;
        }
        .navigation {
            padding: 3px 10px;
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
        .navigation > nav span {}
        .navigation > nav span.current {

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
        .navigation-actions > .actions button,
        .navigation-actions > .actions .button {
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
        .navigation-actions > .actions button:hover,
        .navigation-actions > .actions .button:hover {
            color: #fff!important;
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
        content {
        }
        content .content-wrapper {

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
            min-width: 200px;
        }
        table thead th.price {
            width: 770px;
            max-width: 770px;
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
            min-width: 250px;
            max-width: 250px;
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
                <li><span class="status updated"></span> Updated</li>
                <li><span class="status already-updated"></span> Already Updated</li>
                <li><span class="status not-updated"></span> Not Updated</li>
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
            <div>
                <div class="navigation">
                    <?php
                    // START - Pagination
                    add_filter( 'paginate_links', function( $link ){
                        return filter_input( INPUT_GET, 'update' ) ? remove_query_arg( 'update', $link ) : $link;
                    });
                    echo "<nav>".paginate_links( array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $products->max_num_pages
                    ) )."</nav>";
                    // END- Pagination
                    ?>
                </div>
                <div class="author">
                    Script made by <a target="_blank" href="https://github.com/naiemofficial">Naiem</a>
                    <br>
                    <a class="github" target="_blank" href="https://github.com/naiemofficial/Woocommerce-Currency-Converter/">View on Github</a>
                </div>
            </div>
            <div class="actions">
                <?php if(isset($_GET['update']) && $_GET['update'] == "true"){ ?>
                    <a href="<?php echo the_permalink(). ($paged > 0) ? "page/".$paged : "" ?>"><button class="back">Back to default</button></a>
                    <?php } else if(!isset($_GET['update']) || (isset($_GET['update']) && $_GET['update'] != "true")){ ?>
                        <button class="update" onclick="confirmUpdate(<?php echo $paged; ?>, 'current', '<?php echo the_permalink(). ($paged > 0) ? 'page/'.$paged : '' ?>?update=true')">Update this page</button>
                <?php } ?>
                <button class="update-next" onclick="confirmUpdate(<?php echo $paged; ?>, 'next', '<?php echo the_permalink(). ($paged == 0) ? 'page/'.($paged+2) : (($paged > 0) ? 'page/'.($paged+1) : '') ?>?update=true')">Update Next Page</button>
            </div>
        </div>
    </header>
    <content>
        <div class="content-wrapper">
            <table border="0">
                <thead>
                    <tr>
                        <th width="35px">SL</th>
                        <th width="70px">Image</th>
                        <th width="60px">ID</th>
                        <th class="title">Title</th>
                        <th class="price">Price | New Price</th>
                        <th width="15px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        function displayPrice($status, $price, $updated_price){
                            echo "<span class='".($status == true ? 'updated-price' : 'old-price')."'>".$price."</span>". ($status != true ? "<span class='new-price'>".$updated_price."</span>" : "");
                        }
                        $sl = ($paged > 0) ? ((($paged*$posts_per_page)-$posts_per_page)+1) : 1;
                        if($products->have_posts()): while ( $products->have_posts() ) : $products->the_post(); 
                            global $product;
                            $update = false;
                            $updateEligitble = false;
                            $exchangeStatus = get_post_meta($product->id, 'currency_exchange', true);
                            $exchangeStatus = ($exchangeStatus == "" ? false : $exchangeStatus);
                            if((isset($_GET['update']) && $_GET['update'] == "true" && $exchangeStatus != true) || !isset($_GET['update']) || (isset($_GET['update']) && $_GET['update'] != "true")){
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
                                        <?php if(strlen((string)(float)$_regular_price) > 0 && (float)$_regular_price > 0) { 
                                            $updateEligitble = true;
                                            $updated_price = (float)$_regular_price/$new_price;
                                            if(isset($_GET['update']) && $_GET['update'] == "true"){ 
                                                update_post_meta($product->id, '_regular_price', $updated_price); 
                                                $update = true;
                                            }
                                        ?>
                                            <div><b>Regular:</b> <?php displayPrice($exchangeStatus, $_regular_price, $updated_price); ?></div>
                                        <?php } ?>
                                        <?php if(strlen((string)(float)$_sale_price) > 0 && (float)$_sale_price > 0) {
                                            $updateEligitble = true;
                                            $updated_price = (float)$_sale_price/$new_price;
                                            if(isset($_GET['update']) && $_GET['update'] == "true"){
                                                update_post_meta($product->id, '_sale_price', $updated_price);
                                                $update = true;
                                            }
                                        ?>
                                            <div><b>Sale:</b> <?php displayPrice($exchangeStatus, $_sale_price, $updated_price); ?></div>
                                        <?php } ?>
                                        <?php if(strlen((string)(float)$_price) > 0 && (float)$_price > 0) {
                                            $updateEligitble = true;
                                            $updated_price = (float)$_price/$new_price;
                                            if(isset($_GET['update']) && $_GET['update'] == "true"){
                                                update_post_meta($product->id, '_price', $updated_price);
                                                $update = true;
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
                                                <?php if(strlen((string)(float)$_regular_price) > 0 && (float)$_regular_price > 0) {
                                                    $updateEligitble = true;
                                                    $updated_price = (float)$_regular_price/$new_price;
                                                    if(isset($_GET['update']) && $_GET['update'] == "true"){
                                                        update_post_meta($variation, '_regular_price', $updated_price);
                                                        $update = true;
                                                    }
                                                ?>
                                                    <div><b>Regular:</b> <?php displayPrice($exchangeStatus, $_regular_price, $updated_price); ?></div>
                                                <?php } ?>
                                                <?php if(strlen((string)(float)$_sale_price) > 0 && (float)$_sale_price > 0) {
                                                    $updateEligitble = true;
                                                    $updated_price = (float)$_sale_price/$new_price;
                                                    if(isset($_GET['update']) && $_GET['update'] == "true"){
                                                        update_post_meta($variation, '_sale_price', $updated_price);
                                                        $update = true;
                                                    }
                                                ?>
                                                    <div><b>Sale:</b> <?php displayPrice($exchangeStatus, $_sale_price, $updated_price); ?></div>
                                                <?php } ?>
                                                <?php if(strlen((string)(float)$_price) > 0 && (float)$_price > 0) {
                                                    $updateEligitble = true;
                                                    $updated_price = (float)$_price/$new_price;
                                                    if(isset($_GET['update']) && $_GET['update'] == "true"){
                                                        update_post_meta($variation, '_price', $updated_price);
                                                        $update = true;
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
                                if(isset($_GET['update']) && $_GET['update'] == "true" && $update == true){
                                    update_post_meta($product->id, 'currency_exchange', true);
                                    echo  "<span class='status updated' title='Updated'></span>" ;
                                } else if($exchangeStatus != "" && $exchangeStatus == true){
                                    echo "<span class='status already-updated' title='Already Updated'></span>";
                                } else if($updateEligitble && $exchangeStatus != true) {
                                    echo "<span class='status not-updated' title='Not Updated'></span>";
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