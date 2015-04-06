<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<?php 
foreach ($comments as $comment) {
?>

<div class="comment-view">

    <?= DetailView::widget([
        'model' => $comment,
        'attributes' => [
            'id',
            'content:ntext',
            'issue_id',
            'create_time',
            'create_user_id',
            'update_time',
            'update_user_id',
        ],
    ]) ?>

</div>

<?php } ?>