<?php 
    require_once('../controller/mycv/network.controller.php');
    require_once('../module/mycv/network.php');
?>
    <!-- start of data save message -->
    <div class="container d-flex justify-content-center">
        <div class="text-center text-black bg-warning px-5 rounded-5" name="messageInputEmpty" id="messageInputEmpty1"></div>
    </div>
    <!-- Start of inserting experiences -->
    <?php

        for($i=0; $i<count($networks); $i++){

            if($networks[$i]['media_rightOrLeft'] === 'right'){

                $networkId = (int)$networks[$i]["id"];

                $resultMedia = array_values(array_filter($medias, function($item) use ($networkId) {
                    return isset($item['section_id'])
                        && (int)$item['section_id'] === (int)$networkId;
                }));

                mediaRight($networks, $i, $resultMedia);

            }elseif($networks[$i]['media_rightOrLeft'] === 'left'){

                mediaLeft($networks, $i, $medias);
            }
        }
        networkUmpty($networks);
    ?>
</form>

<script src="../../js/common/tabTextArea.js"></script>
<script src="../../js/common/function.js"></script>
<script src="../../js/common/fetch.js"></script>
<script src="../../js/mycv/mycv.js"></script>
