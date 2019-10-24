<?php
app\assets\AdminAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */

?>
<aside class="main-sidebar">
    <section class="sidebar">
<?= dmstr\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Пользователи', 'url' => ['users/index'], 'icon' => 'users'],
        ['label' => 'Опросы', 'url' => ['questionnaires/index'], 'icon' => 'list-alt'],
        ['label' => 'Результаты', 'url' => ['resultes/index'], 'icon' => 'file']
    ]
]);	
?>
    </section>
</aside>