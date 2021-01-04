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
            $districts = \backend\models\Districts::find()->cache(Yii::$app->params['cache_duration'])->where(['province_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['province_id']])->all();
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
        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['operating_hours']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['district_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['constituency_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['ward_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['ownership_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['name']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['province_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['facility_type_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['operation_status_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['service_category']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['service']) ||
                !empty(Yii::$app->request->queryParams['MFLFacilitySearch']['province_id'])) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            // a hack to create an illusion that a person has not searched yet
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andFilterWhere(['id' => -1]);
        }

        //Filter by province
        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['province_id'])) {
            $district_ids = [];
            $districts = \backend\models\Districts::find()->cache(Yii::$app->params['cache_duration'])
                            ->where(['province_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['province_id']])->all();
            if (!empty($districts)) {
                foreach ($districts as $id) {
                    array_push($district_ids, $id['id']);
                }
            }

            $dataProvider->query->andFilterWhere(['IN', 'district_id', $district_ids]);
        }
        //Filter by district
        /* if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['district_id'])) {
          $dataProvider->query->andFilterWhere(['district_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['district_id']]);
          }
          //Filter by constituency
          if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['constituency_id'])) {
          $dataProvider->query->andFilterWhere(['constituency_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['constituency_id']]);
          }
          //Filter by ward
          if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['ward_id'])) {
          $dataProvider->query->andFilterWhere(['ward_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['ward_id']]);
          }
          //Filter by ownership
          if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['ownership_id'])) {
          $dataProvider->query->andFilterWhere(['ownership_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['ownership_id']]);
          }
          //Filter by facility type
          if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['facility_type_id'])) {
          $dataProvider->query->andFilterWhere(['facility_type_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['facility_type_id']]);
          }
          //Filter by operation status
          if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['operation_status_id'])) {
          $dataProvider->query->andFilterWhere(['operation_status_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['operation_status_id']]);
          } */


        //Filter by service category
        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['service_category'])) {
            $service_ids = [];
            $facility_service_ids = [];
            $services = \backend\models\FacilityService::find()->cache(Yii::$app->params['cache_duration'])
                    ->where(['category_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['service_category']])
                    ->all();
            if (!empty($services)) {
                foreach ($services as $id) {
                    array_push($service_ids, $id['id']);
                }
            }
            if (!empty($service_ids)) {
                $facility_services = \backend\models\MFLFacilityServices::find()
                        ->cache(Yii::$app->params['cache_duration'])
                        ->where(['IN', 'service_id', $service_ids])
                        ->all();
                if (!empty($facility_services)) {
                    foreach ($facility_services as $id) {
                        array_push($facility_service_ids, $id['facility_id']);
                    }
                }
            }
            $dataProvider->query->andFilterWhere(['IN', 'id', $facility_service_ids]);
        }
        //Filter by service
        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['service'])) {
            $facility_service_ids = [];
            $facility_services = \backend\models\MFLFacilityServices::find()
                    ->cache(Yii::$app->params['cache_duration'])
                    ->where(['service_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['service']])
                    ->all();
            if (!empty($facility_services)) {
                foreach ($facility_services as $id) {
                    array_push($facility_service_ids, $id['facility_id']);
                }
            }
            $dataProvider->query->andFilterWhere(['IN', 'id', $facility_service_ids]);
        }

        //Filter by operating hours
        if (!empty(Yii::$app->request->queryParams['MFLFacilitySearch']['operating_hours'])) {
            $facility_service_ids = [];
            $facility_op_hrs = \backend\models\MFLFacilityOperatingHours::find()
                    ->cache(Yii::$app->params['cache_duration'])
                    ->where(['operatinghours_id' => Yii::$app->request->queryParams['MFLFacilitySearch']['operating_hours']])
                    ->all();
            if (!empty($facility_op_hrs)) {
                foreach ($facility_op_hrs as $id) {
                    array_push($facility_service_ids, $id['facility_id']);
                }
            }
            $dataProvider->query->andFilterWhere(['IN', 'id', $facility_service_ids]);
        }

        return $this->render('search', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRating() {
        $model = new \backend\models\MFLFacilityRatings();
        if ($model->load(Yii::$app->request->post())) {

            $rating = Yii::$app->request->post()['MFLFacilityRatings'][$model->rate_type_id]['rating'];
            $model->rate_value = $rating;
            $ratings = [
                1 => 'Very Poor',
                2 => 'Poor',
                3 => 'Average',
                4 => 'Good',
                5 => 'Very Good',
            ];
            $model->rating = $ratings[$rating];
            //  Yii::warning('**********************', var_export("RATTTTIINNNG:::::", true));
            //  Yii::warning('**********************', var_export($model->rating, true));

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Facility rating was successful.');
            } else {
                $message = '';
                foreach ($model->getErrors() as $error) {
                    $message .= $error[0];
                }
                Yii::$app->session->setFlash('error', 'Error occured while rating facility. Error is::.' . $message);
            }
            return $this->renderAjax('success', []);
        }
    }

}
