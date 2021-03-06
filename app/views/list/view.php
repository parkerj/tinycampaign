<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');
/**
 * Edit Email List View
 *  
 * @license GPLv3
 * 
 * @since       2.0.0
 * @package     tinyCampaign
 * @author      Joshua Parker <joshmac3@icloud.com>
 */
$app = \Liten\Liten::getInstance();
$app->view->extend('_layouts/dashboard');
$app->view->block('dashboard');
TinyC\Config::set('screen_parent', 'list');
TinyC\Config::set('screen_child', _escape($list->code));
?>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript">
    /////////////
    // TINYMCE //
    /////////////

    // Initialize TinyMCE
    tinyMCE.init({
        theme : 'modern',
        mode : 'specific_textareas',
        editor_selector: 'template',
        elements : 'message',
        height: '350',
        autosave_ask_before_unload: false,
        relative_urls : false,
        remove_script_host : true,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | gplaceholder | pplaceholder | splaceholder | eplaceholder",
        invalid_elements: "script,object,embed",
        file_picker_callback: elFinderBrowser
    });
    function elFinderBrowser(callback, value, meta) {
        tinymce.activeEditor.windowManager.open({
            file: '<?= get_base_url(); ?>list/elfinder/', // use an absolute path!
            title: 'elFinder 2.0',
            width: 900,
            height: 600,
            resizable: 'yes'
        }, {
            oninsert: function (file) {
                // Provide file and text for the link dialog
                if (meta.filetype == 'file') {
//            callback('mypage.html', {text: 'My text'});
                    callback(file.url);
                }

                // Provide image and alt text for the image dialog
                if (meta.filetype == 'image') {
//            callback('myimage.jpg', {alt: 'My alt text'});
                    callback(file.url);
                }

                // Provide alternative source and posted for the media dialog
                if (meta.filetype == 'media') {
//            callback('movie.mp4', {source2: 'alt.ogg', poster: 'image.jpg'});
                    callback(file.url);
                }
            }
        });
        return false;
    }
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?= _t('View/Edit Email List'); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= get_base_url(); ?>dashboard/"><i class="fa fa-dashboard"></i> <?= _t('Dashboard'); ?></a></li>
            <li><a href="<?= get_base_url(); ?>list/"><i class="ion ion-ios-list"></i> <?= _t('Email Lists'); ?></a></li>
            <li class="active"><?= _t('View/Edit Email List'); ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <?= _tc_flash()->showMessage(); ?> 

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <!-- form start -->
            <form method="post" action="<?= get_base_url(); ?>list/<?=_escape((int)$list->id);?>/" data-toggle="validator" autocomplete="off">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><font color="red">*</font> <?= _t('Code'); ?></label>
                                <input type="text" class="form-control" value="<?=_escape($list->code);?>" readonly required>
                            </div>

                            <div class="form-group">
                                <label><font color="red">*</font> <?= _t('List Name'); ?></label>
                                <input type="text" class="form-control" name="name" value="<?=_escape($list->name);?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _t('List Unsubscribe'); ?>  <a href="#unsub" data-toggle="modal"><span class="badge"><i class="fa fa-question"></i></span></a></label>
                                <input type="text" class="form-control" name="unsub_mailto" value="<?=if_not_null(_escape($list->unsub_mailto));?>">
                            </div>
                            
                            <div class="form-group">
                                <label><?= _t('Short Description'); ?></label>
                                <textarea class="form-control" rows="3" name="description"><?=_escape($list->description);?></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label><font color="red">*</font> <?= _t('Status'); ?></label>
                                <select class="form-control select2" name="status" style="width: 100%;" required>
                                    <option>&nbsp;</option>
                                    <option value="open"<?=selected('open', _escape($list->status), false);?>><?=_t('Open');?></option>
                                    <option value="closed"<?=selected('closed', _escape($list->status), false);?>><?=_t('Closed');?></option>
                                </select>
                                <p class="help-block"><?=_t('If Closed, no one will be able to subscribe to the list.');?></p>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _t('Redirect Success'); ?></label>
                                <input type="text" class="form-control" name="redirect_success" value="<?=_escape($list->redirect_success);?>" >
                                <p class="help-block"><?=_t('Override the default with your custom url success message.');?></p>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label><font color="red">*</font> <?= _t('Notify Email?'); ?>  <a href="#notify" data-toggle="modal"><span class="badge"><i class="fa fa-question"></i></span></a></label>
                                <select class="form-control select2" name="notify_email" style="width: 100%;" required>
                                    <option>&nbsp;</option>
                                    <option value="1"<?=selected('1',_escape((int)$list->notify_email),false);?>><?=_t('Yes');?></option>
                                    <option value="0"<?=selected('0',_escape((int)$list->notify_email),false);?>><?=_t('No');?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _t('Redirect Error'); ?></label>
                                <input type="text" class="form-control" name="redirect_unsuccess" value="<?=_escape($list->redirect_unsuccess);?>" >
                                <p class="help-block"><?=_t('Override the default with your custom url unsuccess message.');?></p>
                            </div>
                            
                            <div class="form-group">
                                <label><font color="red">*</font> <?= _t('Double Opt-in?'); ?></label>
                                <select class="form-control select2" name="optin" style="width: 100%;" required>
                                    <option>&nbsp;</option>
                                    <option value="1"<?=selected('1', _escape((int)$list->optin), false);?>><?=_t('Yes');?></option>
                                    <option value="0"<?=selected('0', _escape((int)$list->optin), false);?>><?=_t('No');?></option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label><font color="red">*</font> <?= _t('SMTP Server'); ?></label>
                                <select class="form-control select2" name="server" style="width: 100%;" required>
                                    <option>&nbsp;</option>
                                    <?php get_user_servers(_escape((int)$list->server));?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _t('Owner'); ?></label>
                                <input type="text" class="form-control" value="<?=get_name(_escape((int)$list->owner));?>"readonly>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _t('Modified'); ?></label>
                                <input type="text" class="form-control" value="<?= Jenssegers\Date\Date::parse(_escape($list->LastUpdate))->format('M. d, Y @ h:i A');?>" readonly>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <label><?= _t('Confirm Email Template'); ?></label>
                                <textarea class="form-control template" rows="3" name="confirm_email"><?=_escape($list->confirm_email);?></textarea>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <label><?= _t('Subscribe Email Template'); ?></label>
                                <textarea class="form-control template" rows="3" name="subscribe_email"><?=_escape($list->subscribe_email);?></textarea>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <label><?= _t('Unsubscribe Email Template'); ?></label>
                                <textarea class="form-control template" rows="3" name="unsubscribe_email"><?=_escape($list->unsubscribe_email);?></textarea>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        
                        <div class="col-md-12">
                            
                            <div class="form-group">
                                <label><?= _t('Subscribe Form'); ?></label>
                                <!-- Custom Tabs -->           
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#plain" data-toggle="tab"><?= _t('Regular'); ?></a></li>
                                        <li><a href="#ajax" data-toggle="tab"><?= _t('Ajax'); ?></a></li>
                                    </ul>
                                    <!-- // Tabs Heading END -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="plain">
<pre>
&lt;form class="form-campaign" method="post" action="<?=get_base_url();?>subscribe/"&gt;
    &lt;p&gt;&lt;label&gt;First Name: &lt;/label&gt;&lt;input type="text" class="input" name="fname" /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;label&gt;Last Name: &lt;/label&gt;&lt;input type="text" class="input" name="lname" /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;label&gt;Email: &lt;/label&gt;&lt;input type="text" class="input" name="email" /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type="hidden" name="m6qIHt4Z5evV" /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type="hidden" name="YgexGyklrgi1" /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type="hidden" name="code" value="<?=_escape($list->code);?>" /&gt;&lt;/p&gt;
    &lt;p&gt;&lt;input type="submit" name="submit" id="submit" value="Submit" /&gt;&lt;/p&gt;
&lt;/form&gt;
</pre>
                                            <p class="help-block"><?=_t('Add this subscribe form to any of your websites to gain subscribers.');?></p>
                                        </div>
                                        <div class="tab-pane" id="ajax">
<pre>
&lt;script type="text/css" src="<?=get_base_url();?>static/assets/css/tinyc/style.css"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"&gt;&lt;/script&gt;
&lt;script type="text/javascript" src="<?=get_base_url();?>static/assets/js/tinyc/magic.js"&gt;&lt;/script&gt;
&lt;div id="newsletterform"&gt;
    &lt;div class="wrap"&gt;
        &lt;form id="newsletter" name="newsletter" method="post" action="<?=get_base_url();?>asubscribe/"&gt;
            &lt;label for="email"&gt;Subscribe to our newsletter&lt;/label&gt;&lt;br /&gt;
            &lt;input type="email" id="signup-email" name="email" placeholder="Enter Email" /&gt;&lt;br /&gt;
            &lt;input type="hidden" name="m6qIHt4Z5evV" /&gt;
            &lt;input type="hidden" name="YgexGyklrgi1" /&gt;
            &lt;input type="hidden" name="code" value="<?=_escape($list->code);?>" /&gt;
            &lt;input type="submit" name="signup-button" id="signup-button" value="Subscribe"&gt;
            &lt;span class="arrow"&gt;&lt;/span&gt;
        &lt;/form&gt;
        &lt;div id="response"&gt;&lt;/div&gt;
    &lt;/div&gt;
&lt;/div&gt;
</pre>
                                            <p class="help-block"><?=_t('Add this subscribe form to any of your websites to gain subscribers.');?></p>
                                        </div>
                                    </div>
                                    <!-- // Custom Tabs END -->
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.col -->
                        
                    </div>
                    <!-- /.row -->
                </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button<?=ie('email_list_inquiry_only');?> type="submit" class="btn btn-primary"><?=_t('Submit');?></button>
                <button type="button" class="btn btn-primary" onclick="window.location='<?=get_base_url();?>list/'"><?=_t( 'Cancel' );?></button>
            </div>
        </form>
        <!-- form end -->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
    
    <!-- modal -->
    <div class="modal" id="notify">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=_t( 'Notify Email' );?></h4>
                </div>
                <div class="modal-body">
                    <p><?=_t( "Set this option to 'Yes' if you would like to receive email every time someone subscribes to your list." );?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= _t('Close'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
    <!-- modal -->
    <div class="modal" id="unsub">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=_t( 'List Unsubscribe' );?></h4>
                </div>
                <div class="modal-body">
                    <p><?=_t( "This is the email address that will receive unsubscribe requests." );?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= _t('Close'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
</div>
<!-- /.content-wrapper -->
<?php $app->view->stop(); ?>
