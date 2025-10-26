<?php 
    require_once('../controller/mycv/home.controller.php');
    require_once('../module/mycv/article.php');
?>

    <!-- start of data save message -->

    <div class="container d-flex justify-content-center">
        <div class="text-center text-black bg-warning px-5 rounded-5" name="messageInputEmpty" id="messageInputEmpty1"></div>
    </div>

    <!-- end of data save message -->

    <!-- Start of inserting articles -->

    <?php

        for($i=0; $i<count($article); $i++){

            if($article[$i]['article_img_rightOrLeft'] === 'right'){

                homeArticleImgRight($article, $i);

            }elseif($article[$i]['article_img_rightOrLeft'] === 'left'){

                homeArticleImgLeft($article, $i);

            }

        }
        
        homeArticleUmpty($article);

    ?>

    <!-- End of article insertion -->

</form>

<script src="../../js/common/function.js"></script>
<script src="../../js/common/fetch.js"></script>
<script src="../../js/mycv/home.js"></script>
