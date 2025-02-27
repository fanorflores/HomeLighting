<?php
require_once("class/app/views/header_template.php");
require_once("class/HL/products.php");
require_once("class/LOCAL/productslocal.php");

$apiClient = new ProductsHL();
$local = new ProductsLocal();
$productslocal = $local->getAllProducts();




?>

<div class="body-bg" style="background-image:url('img/body-bg.jpg')">

    <!-- NFTMax Admin Menu -->
    <?php require_once("class/app/views/main_menu.php"); ?>
    <!-- End NFTMax Admin Menu -->
    <section class="nftmax-adashboard nftmax-show">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-12 nftmax-main__column">
                    <div class="nftmax-body">
                        <div class="nftmax-dsinner">

                            <?php

                            $productslocal = json_decode($productslocal, true);

                            foreach ($productslocal as $product) {
                                $idHl = $product['idHL'];
                                $idGc = $product['idGcP'];

                                var_dump($apiClient->updateAttributeIdGc($idHl, $idGc));
                            }

                            ?>

                        </div>
                    </div>


                </div>

                <?php
                require_once("class/app/views/footer_template.php");
