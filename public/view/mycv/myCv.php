<?php 
    require_once('../controller/mycv/mycv.controller.php');
    require_once('../module/mycv/experience.php');
?>
    <!-- start of data save message -->
    <div class="container d-flex justify-content-center">
        <div class="text-center text-black bg-warning px-5 rounded-5" name="messageInputEmpty" id="messageInputEmpty1"></div>
    </div>
    <!-- Start of inserting experiences -->
    <?php

        for($i=0; $i<count($experiences); $i++){

            if($experiences[$i]['img_rightOrLeft'] === 'right'){

                mycvExperienceImgRight($experiences, $i);

            }elseif($experiences[$i]['img_rightOrLeft'] === 'left'){

                mycvExperienceImgLeft($experiences, $i);
            }
        }
        mycvExperienceUmpty($experiences);
    ?>
</form>

<script src="../../js/common/tabTextArea.js"></script>
<script src="../../js/common/function.js"></script>
<script src="../../js/common/fetch.js"></script>
<script src="../../js/mycv/mycv.js"></script>
