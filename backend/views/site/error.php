<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="site-error">

    <?php
    $arr = explode("(", $name);
    $error_code = str_replace(")", "", str_replace("#", "", $arr[1]));
    ?>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <?php
            if ($error_code == 404) {
                echo '<h2 class="headline text-warning">' . $error_code . '</h2>' .
                '  <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="'.Url::to('@web/site/home').'">return to dashboard</a>.
                </p>
            </div>';
            } else {
                echo '<h2 class="headline text-danger">' . $error_code . '</h2>' .
                '  <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>

          <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href="'.Url::to('@web/site/home').'">return to dashboard</a>.
          </p>';
            }
            ?>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>

</div>
