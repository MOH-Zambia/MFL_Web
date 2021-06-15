

<script>
         var myArrSuccess = [<?php
$flashMessage = Yii::$app->session->getFlash('success');
if ($flashMessage) {
    echo '"' . $flashMessage . '",';
}
?>];
         for (var i = 0; i < myArrSuccess.length; i++) {
             $.notify(myArrSuccess[i], {
                 type: 'success',
                 offset: 100,
                 allow_dismiss: true,
                 newest_on_top: true,
                 timer: 5000,
                 placement: {from: 'top', align: 'right'}
             });
         }
         var myArrError = [<?php
$flashMessage = Yii::$app->session->getFlash('error');
if ($flashMessage) {
    echo '"' . $flashMessage . '",';
}
?>];
         for (var j = 0; j < myArrError.length; j++) {
             $.notify(myArrError[j], {
                 type: 'danger',
                 offset: 100,
                 allow_dismiss: true,
                 newest_on_top: true,
                 timer: 5000,
                 placement: {from: 'top', align: 'right'}
             });
         }
</script>
