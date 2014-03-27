<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2013
 * @package yii2-grid
 * @version 1.0.0
 */

namespace kartik\grid\controllers;

use Yii;
use yii\helpers\Json;

class ExportController extends \yii\web\Controller
{

	/**
	 * Download the exported file
	 */
	public function actionDownload()
	{
		$type = empty($_POST['export_filetype']) ? 'html' : $_POST['export_filetype'];
		$name = empty($_POST['export_filename']) ? Yii::t('kvgrid', 'export') : $_POST['export_filename'];
		$content = empty($_POST['export_content']) ? Yii::t('kvgrid', 'No data found') : $_POST['export_content'];
		$this->setHttpHeaders($type, $name);
		return $content;
	}

	/**
	 * Sets the HTTP headers needed by file download action.
	 */
	protected function setHttpHeaders($type, $name)
	{
		if ($type == 'csv') {
			$mime = 'text/csv';
		}
		elseif ($type == 'html') {
			$mime = 'text/html';
		}
		else {
			$mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
			$type = 'xlsx';
		}
		Yii::$app->getResponse()->getHeaders()
			->set('Pragma', 'public')
			->set('Expires', '0')
			->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
			->set('Content-Disposition', 'attachment; filename="'.$name.'.'.$type.'"')
			->set('Content-type', $mime);
	}
}