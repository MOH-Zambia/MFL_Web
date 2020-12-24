<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use frontend\models\MFLFacility;
use frontend\models\MFLFacilitySearch;

/**
 * Facility controller
 */
class FacilityController extends Controller {

    /**
     * Displays a single MFLFacility model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = \frontend\models\MFLFacility::find()
                        ->select(['*', 'ST_AsGeoJSON(geom) as geom'])
                        ->where(["id" => $id])->one();
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    /**
     * Lists all MFLFacility models.
     * @return mixed
     */
    public function actionIndex($facility_type_id = "", $ownership_id = "") {
        $searchModel = new MFLFacilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['province_id'])) {
            $district_ids = [];
            $districts = \backend\models\Districts::find()->where(['province_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['province_id']])->all();
            if (!empty($districts)) {
                foreach ($districts as $id) {
                    array_push($district_ids, $id['id']);
                }
            }

            $dataProvider->query->andFilterWhere(['IN', 'district_id', $district_ids]);
        }
        if (!empty($facility_type_id)) {
            $dataProvider->query->andFilterWhere(['facility_type_id' => $facility_type_id]);
        }
        if (!empty($ownership_id)) {
            $dataProvider->query->andFilterWhere(['ownership_id' => $ownership_id]);
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch() {
        $searchModel = new MFLFacilitySearch();
        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch'])) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            // a hack to create an illusion that a person has not searched yet
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andFilterWhere(['id' => -1]);
        }

        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['province_id'])) {
            $district_ids = [];
            $districts = \backend\models\Districts::find()->where(['province_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['province_id']])->all();
            if (!empty($districts)) {
                foreach ($districts as $id) {
                    array_push($district_ids, $id['id']);
                }
            }

            $dataProvider->query->andFilterWhere(['IN', 'district_id', $district_ids]);
        }

        return $this->render('search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

}
