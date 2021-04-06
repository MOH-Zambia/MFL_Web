<?php

namespace frontend\controllers;

use Yii;
use backend\models\Indicators;
use backend\models\IndicatorsSearch1;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;

/**
 * IndicatorsController implements the CRUD actions for Indicators model.
 */
class IndicatorsController extends Controller {

    /**
     * Lists all Indicators models.
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'nids';
        $searchModel = new IndicatorsSearch1();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'attributes' => [
                'id' => [
                    'desc' => ['id' => SORT_DESC],
                    'default' => SORT_DESC
                ],
            ],
            'defaultOrder' => [
                'id' => SORT_DESC
            ]
        ]);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Indicators model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->layout = 'nids';
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionDownload($id) {

        $model = $this->findModel($id);
        $filename = "NIDS_" . date("Ymd") . "_indicators" . ".pdf";
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('download',
                    [
                        'model' => $model,
            ]),
            'options' => [
                'text_input_as_HTML' => true,
                'target' => '_blank',
            // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'Indicator',
                //'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['NIDS/Indicator||' . date("r") . "/MOH online"],
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'MOH online',
            ]
        ]);
        $pdf->filename = $filename;
        return $pdf->render();
    }

    /**
     * Finds the Indicators model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Indicators the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Indicators::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
