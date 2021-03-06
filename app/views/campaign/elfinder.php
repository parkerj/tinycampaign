<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
/**
 * File Manager Window
 * 
 * This file will be called when the image button is invoked on
 * tinyMCE
 *  
 * @license GPLv3
 * 
 * @since       2.0.0
 * @package     tinyCampaign
 * @author      Joshua Parker <joshmac3@icloud.com>
 */
$app = \Liten\Liten::getInstance();
$app->view->extend('_layouts/blank');
$app->view->block('blank');
error_reporting(0);
?>

<!DOCTYPE html>
<html>
    <head>
        <base href="<?= get_base_url(); ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= (isset($title)) ? $title . ' - ' . _h(get_option('system_name')) : _h(get_option('system_name')); ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
            var rootPath = '<?= get_base_url(); ?>';
        </script>
        <!-- jQuery 2.2.3 -->
        <script src="static/assets/js/jQuery/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="static/assets/js/bootstrap/bootstrap.min.js"></script>
        <link href="static/assets/js/elfinder/css/elfinder.min.css" type="text/css" rel="stylesheet" />
        <link href="static/assets/js/elfinder/css/theme.css" type="text/css" rel="stylesheet" />
        <script src="static/assets/js/elfinder/js/elfinder.full.js" type="text/javascript"></script>
        <script src="static/assets/js/elfinder/js/tinymce.plugin.js" type="text/javascript"></script>
    </head>
    <body class="">

        <div class="widget-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel-body">
                        <div id="elfinder"></div>
                    </div>
                </div>
           	</div>
        </div>

    </body>
</html>
<?php $app->view->stop(); ?>