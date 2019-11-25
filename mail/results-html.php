<?php
/* @var $this yii\web\View */
/* @var $data app\models\Results */
?>

<table style="padding:0;width:100%;border-collapse:collapse;border-spacing:0;margin:30px auto;">
    <tbody>
        <tr style="padding:0;text-align:left;vertical-align:top;width:100%;">
            <td>                 
                <h3 style="color:#485671;font:400 24px Arial;margin:35px 0;">Поступила новая заявка с опроса "<?= $data->questionnaire->title ?>"</h3>
                
                <div style="margin-bottom:30px;">
                    <span style="color:#4a5773;font:400 16px Arial;">Контакты:</span>
                </div>
                <div style="margin-bottom:30px;">
                    <span style="color: #4a5773;font:400 16px Arial;">Имя: <?= $data->name ?></span><br />
                    <span style="color: #4a5773;font:400 16px Arial;">Телефон: <?= $data->phone ?></span>
                </div>
                <div style="margin-bottom:30px;">
                    <span style="color:#4a5773;font:400 16px Arial;">Ответы:</span>
                
                <?php 
                $result = '<table><tbody>';
                foreach ($data->makeQuestions() as $question => $answer) {
                    $result.= '<tr><th style="text-align:left;">' . $question . '</th><td style="text-align:right;">' . $answer . '</td></tr>';
                }
                $result.= '</tbody></table>';
                echo $result;
                ?>
                </div>
                <div style="margin-bottom:30px;">
                    <span style="color:#4a5773;font:400 16px Arial;">Скидка:</span>
                    <span style="color:#4a5773;font:400 16px Arial;"><?= $data->discount ?></span>
                </div>
                <div style="margin-bottom:30px;">
                    <span style="color:#4a5773;font:400 16px Arial;">Страница:</span>
                    <span style="color:#4a5773;font:400 16px Arial;"><a href="<?= $data->referrer ?>">Перейти</a></span>
                </div>
                
                <hr style="border:0;height:1px;background-color:#687aa1;margin:5px 0 35px 0;width:calc(100% - 50px);"/>
                
                <div style="margin-bottom:30px;">
                    <span style="color:#4a5773;font:400 16px Arial;">Время заявки: <?= Yii::$app->formatter->asDateTime($data->created_at, 'php:d F Y, H:i') ?></span><br />
                </div>
                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['results/view', 'id' => $data->id]) ?>" style="color:#1c69ff;font:400 16px Arial;margin:30px 0;">Посмотреть в личном кабинете</a>
            </td>
        </tr>
    </tbody>            
</table>