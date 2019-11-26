<?php include 'partials/header.php'; ?>

<?php
//$templates = file_get_contents('https://microweber.org/api/market_json');
//$templates = json_decode($templates, true);

$connector = new \MicroweberAddon\MarketplaceConnector();
$templates = $connector->get_packages();

?>

<?php if ($templates["microweber-template"]): ?>
    <?php foreach ($templates["microweber-template"] as $template): ?>
    <?php

        $template['name']  = $template['latest_version']['name'];
        $template['description']  = $template['latest_version']['description'];

        ?>
        <?php if (isset($_GET['template']) AND $template['name'] == $_GET['template']): ?>
            <?php
            $screenshot = '';
            if (isset($template['latest_version']) AND isset($template['latest_version']['extra']) AND isset($template['latest_version']['extra']['_meta']) AND isset($template['latest_version']['extra']['_meta']['screenshot'])) {
                $screenshot = $template['latest_version']['extra']['_meta']['screenshot'];
            }

            $description = '';
            if (isset($template['description'])) {
                $description = $template['description'];
            }

            $homepage = 'http://microweber.com';
            if (isset($template['homepage'])) {
                $homepage = $template['homepage'];
            }

            $preview_url = 'http://microweber.com';
            if (isset($template['latest_version']) AND isset($template['latest_version']['extra']) AND isset($template['latest_version']['extra']['preview_url'])) {
                $preview_url = $template['latest_version']['extra']['preview_url'];
                $preview_url = str_replace('http://', 'https://', $preview_url);
            }

            ?>

            <?php




            include dirname(dirname(dirname(__DIR__))) . '/params.php'; ?>

            <div class="preview-navbar">
                <div class="left logo">
                    <a href="javascript:;" onclick="window.history.back()" class="btn btn-default"><i class="fa fa-chevron-left"></i></a>
                </div>

                <div class="right buttons">

                    <form method="get" action="<?php echo $current_url ?>" class="clearfix">
                        <input type="hidden" value="false" name="template_view"/>

                        <?php include dirname(dirname(dirname(__DIR__))) . '/params_fields.php'; ?>

                        <a href="javascript:;" class="btn btn-default-outline" onclick="submitForPreview(this.parentNode);">Започни с този темплейт</a>
                        &nbsp;
                        <a class="btn btn-default" href="<?php print $preview_url; ?>" target="_blank"><i class="fa fa-times"></i></a>
                    </form>
                </div>
            </div>
            <?php if ($preview_url): ?>
                <iframe src="<?php print $preview_url; ?>" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php include 'partials/footer.php'; ?>