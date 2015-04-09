<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="comment-view">
<h3>最新评论</h3>
<?php 
foreach ($comments as $comment) {
?>
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
<?php } ?>
</div>